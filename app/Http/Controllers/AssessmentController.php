<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\User;
use App\Models\Period;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $students = User::where('guru_pembimbing_id', $user->id)->where('role', 'siswa')->with('assessments', 'industry')->get();

        return view('assessments.index', compact('students'));
    }

    public function create(User $student)
    {
        $user = auth()->user();
        if ($student->guru_pembimbing_id !== $user->id) {
            abort(403);
        }

        $activePeriod = Period::active()->first();
        $existing = Assessment::where('user_id', $student->id)
            ->where('assessor_id', $user->id)
            ->where('period_id', $activePeriod?->id)
            ->first();

        return view('assessments.create', compact('student', 'activePeriod', 'existing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'period_id' => 'nullable|exists:periods,id',
            'soft_skill_score' => 'required|numeric|min:0|max:100',
            'hard_skill_score' => 'required|numeric|min:0|max:100',
            'discipline_score' => 'required|numeric|min:0|max:100',
            'attitude_score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $assessment = Assessment::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'assessor_id' => auth()->id(),
                'period_id' => $request->period_id,
            ],
            [
                'soft_skill_score' => $request->soft_skill_score,
                'hard_skill_score' => $request->hard_skill_score,
                'discipline_score' => $request->discipline_score,
                'attitude_score' => $request->attitude_score,
                'notes' => $request->notes,
            ]
        );

        $assessment->calculateTotal();
        $assessment->save();

        return redirect()->route('assessments.index')->with('success', 'Penilaian berhasil disimpan.');
    }
}
