<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalComment;
use App\Models\User;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $studentIds = User::where('pembimbing_industri_id', $user->id)->pluck('id');

        $query = Journal::whereIn('user_id', $studentIds)->with('user', 'photos');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'menunggu');
        }

        $journals = $query->latest('date')->paginate(10);

        return view('validation.index', compact('journals'));
    }

    public function review(Journal $journal)
    {
        $user = auth()->user();
        $studentIds = User::where('pembimbing_industri_id', $user->id)->pluck('id');

        if (!$studentIds->contains($journal->user_id)) {
            abort(403, 'Anda tidak memiliki akses ke jurnal ini.');
        }

        $journal->load('user', 'photos', 'comments.user');

        return view('validation.review', compact('journal'));
    }

    public function approve(Request $request, Journal $journal)
    {
        $request->validate([
            'comment' => 'nullable|string|max:1000',
        ]);

        $journal->update(['status' => 'terverifikasi']);

        if ($request->filled('comment')) {
            JournalComment::create([
                'journal_id' => $journal->id,
                'user_id' => auth()->id(),
                'comment' => $request->comment,
            ]);
        }

        return redirect()->route('validation.index')->with('success', 'Jurnal berhasil diverifikasi.');
    }

    public function reject(Request $request, Journal $journal)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $journal->update(['status' => 'revisi']);

        JournalComment::create([
            'journal_id' => $journal->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('validation.index')->with('success', 'Jurnal dikembalikan untuk revisi.');
    }
}
