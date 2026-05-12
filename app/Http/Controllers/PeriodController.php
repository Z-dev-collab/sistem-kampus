<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::withCount('users')->latest()->paginate(10);
        return view('admin.periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.periods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        Period::create($request->all());
        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit(Period $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    public function update(Request $request, Period $period)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $period->update($request->all());
        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy(Period $period)
    {
        $period->delete();
        return redirect()->route('admin.periods.index')->with('success', 'Periode berhasil dihapus.');
    }
}
