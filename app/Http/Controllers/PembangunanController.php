<?php

namespace App\Http\Controllers;

use App\Models\Pembangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembangunanController extends Controller
{

    public function proses()
    {
        return view('internal.pengajuan_pembangunan.lpmd.proses');
    }

    public function detailPengajuan($id)
    {
        $pengajuan = Pembangunan::find($id);

        if (!$pengajuan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Uraikan JSON di field dokumentasi
        $dokumentasi = [];
        if ($pengajuan->dokumentasi) {
            $files = json_decode($pengajuan->dokumentasi, true);
            $dokumentasi = array_map(function ($file) {
                return url("storage/img/{$file}");
            }, $files);
        }

        return response()->json([
            'nama' => $pengajuan->nama,
            'status' => $pengajuan->status,
            'tanggal_pengajuan' => $pengajuan->tanggal_pengajuan,
            'keterangan' => $pengajuan->deskripsi ?? 'Tidak ada keterangan',
            'dokumentasi' => $dokumentasi,
        ]);
    }


    // RIWAYAT PENGAJUAN RT
    public function riwayatPengajuanRt()
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $riwayat = Pembangunan::where('id_users', $userId)->get(); // Ambil riwayat pengajuan berdasarkan user
        return view('internal.pengajuan_pembangunan.rt.riwayat', compact('riwayat'));
    }

    // RIWAYAT PENGAJUAN RW
    public function riwayatPengajuanRw()
    {
        $riwayat = Pembangunan::where('status', '!=', 'menunggu_verifikasi')->get(); // Ambil semua pengajuan yang telah diverifikasi RT
        return view('internal.pengajuan_pembangunan.rw.riwayat', compact('riwayat'));
    }


    // MENAMPILKAN DATA YANG SUDAH DIVALIDASI LPMD UNTUK DI PROSES (DATA ALTERNATIF)
    public function dataAlternatif()
    {
        $pembangunan = Pembangunan::where('persetujuan', 'disetujui')
            ->where('validasi', 'divalidasi')
            ->get();

        return view('internal.pengajuan_pembangunan.lpmd.alternatif', compact('pembangunan'));
    }

    // VALIDASI USULAN YANG SUDAH DI VERIFIKASI RW (LPMD)

    public function verifikasi()
    {
        $pembangunan = Pembangunan::whereNull('persetujuan')->get();

        // Ubah dokumentasi ke array kosong jika null
        foreach ($pembangunan as $item) {
            $item->dokumentasi = $item->dokumentasi ? json_decode($item->dokumentasi, true) : [];
        }

        return view('internal.pengajuan_pembangunan.rw.verifikasi', compact('pembangunan'));
    }



    public function approveValidasi(Request $request)
    {
        $selectedIds = $request->input('selected'); // Ambil data yang dipilih
        Pembangunan::whereIn('id', $selectedIds)->update([
            'validasi' => 'divalidasi',
            'status' => 'divalidasi'
        ]);
        return redirect()->back()->with('success', 'Data berhasil divalidasi');
    }

    public function rejectValidasi(Request $request)
    {
        $request->validate([
            'selected' => 'required|array',
            'keterangan' => 'required|array'
        ], [
            'selected.required' => 'Pilih minimal satu data untuk ditolak.',
            'keterangan.required' => 'Alasan penolakan diperlukan.'
        ]);

        $selectedIds = $request->input('selected');
        $keterangan = $request->input('keterangan');

        foreach ($selectedIds as $id) {
            Pembangunan::where('id', $id)->update([
                'validasi' => 'ditolak',
                'status' => 'ditolak',
                'keterangan_validasi' => $keterangan[$id] ?? ''
            ]);
        }

        return redirect()->back()->with('success', 'Data validasi berhasil ditolak');
    }

    public function validasi()
    {
        $pembangunan = Pembangunan::where('persetujuan', 'disetujui')
            ->whereNull('validasi')
            ->get(); // Menampilkan data yang sudah disetujui tapi belum divalidasi

        // Ubah dokumentasi ke array kosong jika null
        foreach ($pembangunan as $item) {
            $item->dokumentasi = $item->dokumentasi ? json_decode($item->dokumentasi, true) : [];
        }

        return view('internal.pengajuan_pembangunan.lpmd.validasi', compact('pembangunan'));
    }


    // VERIFIKASI USULAN YANG DI BUAT OLEH RT (RW


    public function approve(Request $request)
    {
        $selectedIds = $request->input('selected'); // Ambil data yang dipilih
        Pembangunan::whereIn('id', $selectedIds)->update([
            'persetujuan' => 'disetujui',
            'status' => 'disetujui'
        ]);
        return redirect()->back()->with('success', 'Data berhasil disetujui');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'selected' => 'required|array',
            'keterangan' => 'required|array'
        ], [
            'selected.required' => 'Pilih minimal satu data untuk ditolak.',
            'keterangan.required' => 'Alasan penolakan diperlukan.'
        ]);

        $selectedIds = $request->input('selected');
        $keterangan = $request->input('keterangan');

        foreach ($selectedIds as $id) {
            Pembangunan::where('id', $id)->update([
                'persetujuan' => 'ditolak',
                'status' => 'ditolak',
                'validasi' => $keterangan[$id] ?? ''
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil ditolak');
    }


    // MEMBUAT USULAN UNTUK PEMBANGUNAN (RT)

    public function create()
    {
        return view('internal.pengajuan_pembangunan.create');
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'biaya' => 'required',
            'dokumentasi.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Persiapkan data untuk disimpan
        $data = [
            'id_users' => $user->id, // Isi id_users dengan ID pengguna yang sedang login
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'pengusul' => $user->nama_lengkap, // Ambil nama lengkap dari user yang sedang login
            'kategori' => $request->kategori,
            'biaya' => $request->biaya,
            'lokasi' => $request->lokasi,
            'tanggal_pengajuan' => now()->toDateString(),
            'status' => 'menunggu_verifikasi', // Status default
        ];

        // Upload multiple dokumentasi jika tersedia
        $this->processMultipleImageUpload($request, 'dokumentasi', $data);

        // Simpan data Pembangunan
        Pembangunan::create($data);

        return redirect()->route('home')->with('success', 'Data Telah Tersimpan, Harap Menunggu Persetujuan Dari Pihak RW');
    }




    private function processMultipleImageUpload($request, $fieldName, &$data, $model = null)
    {
        if ($request->hasFile($fieldName)) {
            $images = $request->file($fieldName);
            $imageNames = [];

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/img', $imageName);
                $imageNames[] = $imageName;
            }

            // Jika model ada dan memiliki file lama, hapus file lama
            if ($model && $model->$fieldName) {
                $oldImages = json_decode($model->$fieldName);
                foreach ($oldImages as $oldImage) {
                    Storage::delete('public/img/' . $oldImage);
                }
            }

            // Simpan nama gambar dalam array yang di-encode ke JSON
            $data[$fieldName] = json_encode($imageNames);
        } elseif ($model && $model->$fieldName) {
            // Jika tidak ada file baru diunggah, tetap gunakan file lama
            $data[$fieldName] = $model->$fieldName;
        }
    }
}
