<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::withCount('users')->latest()->paginate(10);
        return view('admin.industries.index', compact('industries'));
    }

    public function create()
    {
        return view('admin.industries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'geofence_radius' => 'nullable|integer|min:10|max:5000',
        ]);

        Industry::create($request->all());
        return redirect()->route('admin.industries.index')->with('success', 'Industri berhasil ditambahkan.');
    }

    public function edit(Industry $industry)
    {
        return view('admin.industries.edit', compact('industry'));
    }

    public function update(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);
        $industry->update($request->all());
        return redirect()->route('admin.industries.index')->with('success', 'Industri berhasil diperbarui.');
    }

    public function destroy(Industry $industry)
    {
        $industry->delete();
        return redirect()->route('admin.industries.index')->with('success', 'Industri berhasil dihapus.');
    }
}
