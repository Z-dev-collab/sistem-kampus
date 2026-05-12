<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Journal::where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('month')) {
            $query->whereMonth('date', Carbon::parse($request->month)->month)
                  ->whereYear('date', Carbon::parse($request->month)->year);
        }

        $journals = $query->with('photos')->latest('date')->paginate(10);

        return view('journals.index', compact('journals'));
    }

    public function create()
    {
        $today = Carbon::today();
        $existing = Journal::where('user_id', auth()->id())->where('date', $today)->first();

        if ($existing) {
            return redirect()->route('journals.edit', $existing)->with('info', 'Jurnal hari ini sudah ada. Silakan edit.');
        }

        return view('journals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|min:10',
            'competency_category' => 'nullable|string|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $existing = Journal::where('user_id', auth()->id())->where('date', $request->date)->first();
        if ($existing) {
            return back()->withErrors(['date' => 'Jurnal untuk tanggal ini sudah ada.']);
        }

        $journal = Journal::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'description' => $request->description,
            'competency_category' => $request->competency_category,
            'status' => $request->has('submit') ? 'menunggu' : 'draft',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('journals/' . auth()->id(), 'public');
                JournalPhoto::create([
                    'journal_id' => $journal->id,
                    'photo_path' => $path,
                    'caption' => $request->captions[$index] ?? null,
                ]);
            }
        }

        $message = $journal->status === 'menunggu'
            ? 'Jurnal berhasil dikirim untuk validasi.'
            : 'Jurnal berhasil disimpan sebagai draft.';

        return redirect()->route('journals.index')->with('success', $message);
    }

    public function show(Journal $journal)
    {
        $this->authorizeJournal($journal);
        $journal->load('photos', 'comments.user');

        return view('journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        $this->authorizeJournal($journal);

        if ($journal->status === 'terverifikasi') {
            return back()->with('error', 'Jurnal yang sudah terverifikasi tidak dapat diedit.');
        }

        $journal->load('photos');
        return view('journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $this->authorizeJournal($journal);

        if ($journal->status === 'terverifikasi') {
            return back()->with('error', 'Jurnal yang sudah terverifikasi tidak dapat diedit.');
        }

        $request->validate([
            'description' => 'required|string|min:10',
            'competency_category' => 'nullable|string|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $journal->update([
            'description' => $request->description,
            'competency_category' => $request->competency_category,
            'status' => $request->has('submit') ? 'menunggu' : 'draft',
        ]);

        // Delete removed photos
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = JournalPhoto::find($photoId);
                if ($photo && $photo->journal_id === $journal->id) {
                    Storage::disk('public')->delete($photo->photo_path);
                    $photo->delete();
                }
            }
        }

        // Add new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('journals/' . auth()->id(), 'public');
                JournalPhoto::create([
                    'journal_id' => $journal->id,
                    'photo_path' => $path,
                    'caption' => $request->captions[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('journals.show', $journal)->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Journal $journal)
    {
        $this->authorizeJournal($journal);

        if ($journal->status === 'terverifikasi') {
            return back()->with('error', 'Jurnal yang sudah terverifikasi tidak dapat dihapus.');
        }

        foreach ($journal->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $journal->delete();

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil dihapus.');
    }

    private function authorizeJournal(Journal $journal)
    {
        if ($journal->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}
