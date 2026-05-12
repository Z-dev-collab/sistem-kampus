<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Industry;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        $users = $query->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $industries = Industry::active()->get();
        $periods = Period::active()->get();
        $guruList = User::where('role', 'guru_pembimbing')->get();
        $pembimbingList = User::where('role', 'pembimbing_industri')->get();
        return view('admin.users.create', compact('industries', 'periods', 'guruList', 'pembimbingList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:siswa,pembimbing_industri,guru_pembimbing,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'phone' => $request->phone,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'industry_id' => $request->industry_id,
            'guru_pembimbing_id' => $request->guru_pembimbing_id,
            'pembimbing_industri_id' => $request->pembimbing_industri_id,
            'period_id' => $request->period_id,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $industries = Industry::active()->get();
        $periods = Period::all();
        $guruList = User::where('role', 'guru_pembimbing')->where('id', '!=', $user->id)->get();
        $pembimbingList = User::where('role', 'pembimbing_industri')->where('id', '!=', $user->id)->get();
        return view('admin.users.edit', compact('user', 'industries', 'periods', 'guruList', 'pembimbingList'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:siswa,pembimbing_industri,guru_pembimbing,admin',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
