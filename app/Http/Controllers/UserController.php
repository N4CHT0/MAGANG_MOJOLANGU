<?php

namespace App\Http\Controllers;

use App\Models\SKTM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Display a listing of the resource.
    public function history()
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Mengambil data SKTM yang nama_lengkapnya sama dengan pengguna yang sedang login
        $sktm = SKTM::where('nama_lengkap', $user->nama_lengkap)
            ->get()
            ->map(function ($item) {
                $item->source = 'Pengajuan SKTM';
                return $item;
            });

        // Contoh model lain
        // $modelLain = ModelLain::where('nama_lengkap', $user->nama_lengkap)
        //                       ->get()
        //                       ->map(function($item) {
        //                           $item->source = 'Pengajuan Model Lain';
        //                           return $item;
        //                       });

        // Menggabungkan semua data dalam satu koleksi
        // $data = $sktm->merge($modelLain); // Jika ada model lain
        $data = $sktm; // Jika hanya ada satu model

        return view('users.history', compact('data'));
    }

    public function update_data_warga(Request $request)
    {
        // Ambil data pengguna yang sedang login
        $currentUser = auth()->user();

        // Cek apakah pengguna sudah pernah memperbarui data
        if ($currentUser->data_updated) {
            return redirect()->back()->with('error', 'Anda sudah pernah memperbarui data.');
        }

        // Validasi input
        $request->validate([
            'no_kk' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'status_perkawinan' => 'required|string',
            'telegram_number' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        // Perbarui data pengguna
        $currentUser->update([
            'no_kk' => $request->no_kk,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'status_perkawinan' => $request->status_perkawinan,
            'telegram_number' => $request->telegram_number,
            'pendidikan' => $request->pendidikan,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'data_updated' => true, // Tandai data sebagai sudah diperbarui
        ]);

        return redirect()->route('home')->with('success', 'Data berhasil diperbarui.');
    }



    // Show the form for creating a new resource.
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Display the specified resource.
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Show the form for editing the specified resource.
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'role' => $request->role,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
