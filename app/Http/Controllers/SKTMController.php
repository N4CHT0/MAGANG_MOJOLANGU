<?php

namespace App\Http\Controllers;

use App\Models\SKTM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SKTMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sktms = SKTM::all();
        return view('pelayanan.sktm.index', compact('sktms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelayanan.sktm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'foto_kk' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'foto_ktp' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'rw' => 'required|string',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
        ];

        // Simpan file foto jika ada
        $this->processImageUpload($request, 'foto_ktp', $data);
        $this->processImageUpload($request, 'foto_kk', $data);

        SKTM::create($data);

        \Log::info('Redirecting to home route');
        return redirect()->route('dashboard')->with('success', 'Data Telah Tersimpan, Harap Menunggu Validasi Dari Pihak RT');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function deleteRelatedFiles($data)
    {
        $fileFields = ['foto'];

        foreach ($fileFields as $fieldName) {
            if ($data->$fieldName) {
                Storage::delete('public/img/' . basename($data->$fieldName));
            }
        }
    }

    private function processImageUpload($request, $fieldName, &$data, $model = null)
    {
        if ($request->hasFile($fieldName)) {
            $image = $request->file($fieldName);
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/img', $imageName);

            // Hapus file lama jika sedang melakukan update
            if ($model && $model->$fieldName) {
                Storage::delete('public/img/' . $model->$fieldName);
            }

            // Tambahkan nama file ke data
            $data[$fieldName] = $imageName;
        } elseif ($model && $model->$fieldName) {
            // Jika tidak ada file baru diupload, tetapi ada file lama, gunakan file lama
            $data[$fieldName] = $model->$fieldName;
        }
    }
}
