<?php

namespace App\Http\Controllers;

use App\Models\SKTM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class SKTMController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek akses berdasarkan role user
        if ($user->role == 'kelurahan') {
            // Untuk user dengan role 'kelurahan', tampilkan hanya data yang tervalidasi
            $data = SKTM::where('validasi', 'tervalidasi')->get();
        } elseif (!in_array($user->role, ['rt', 'admin'])) {
            // Cek akses untuk role lainnya
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        } else {
            // Untuk user dengan role 'rt', hanya tampilkan data berdasarkan RT mereka
            // Untuk role 'admin', tampilkan semua data
            $data = $user->role === 'rt' ? SKTM::where('rt', $user->rt)->get() : SKTM::all();
        }

        return view('pelayanan.sktm.index', compact('data'));
    }

    public function validateSKTM(Request $request, $id)
    {
        $data = SKTM::findOrFail($id);
        $data->validasi = 'tervalidasi';

        // Generate PDF
        $pdf = $this->generatePDF($data);

        // Save PDF and get filename
        $pdfName = $this->processPDFUpload($pdf, $id);

        // Save PDF name to 'surat_pengantar'
        $data->surat_pengantar = $pdfName;

        $data->save();

        return redirect()->route('sktms.index')->with('success', 'Pengajuan SKTM berhasil divalidasi dan PDF telah disimpan.');
    }

    public function viewPDF($filename)
    {
        $path = storage_path('app/public/pdf/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control' => 'public, must-revalidate, proxy-revalidate',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }


    public function finalSKTM(Request $request, $id)
    {
        $data = SKTM::findOrFail($id);
        $data->validasi = 'final';
        $data->save();

        return redirect()->route('sktms.index')->with('success', 'Pengajuan SKTM berhasil difinalisasi.');
    }

    public function rejectSKTM(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string'
        ]);

        $data = SKTM::findOrFail($id);
        $data->validasi = 'ditolak';
        $data->keterangan = $request->input('keterangan');
        $data->save();

        return redirect()->route('sktms.index')->with('success', 'Pengajuan SKTM ditolak.');
    }

    public function downloadSKTM($id)
    {
        // Ambil data SKTM berdasarkan ID
        $data = SKTM::findOrFail($id);

        // Pastikan ada nama file PDF di field 'surat_pengantar'
        if (!$data->surat_pengantar) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        // Path file PDF di storage
        $pdfPath = storage_path('app/public/pdf/' . $data->surat_pengantar);

        // Cek apakah file ada
        if (!file_exists($pdfPath)) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        // Unduh file PDF
        return response()->download($pdfPath);
    }


    private function generatePDF($data)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('report.surat_pengantar', compact('data'))->render());
        $dompdf->setPaper('F4', 'portrait');
        $dompdf->render();

        return $dompdf;
    }

    private function processPDFUpload($pdf, $id)
    {
        $pdfName = 'surat_pengantar_' . $id . '.pdf';
        Storage::put('public/pdf/' . $pdfName, $pdf->output());

        return $pdfName;
    }

    public function onlyView()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['rw'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data = $user->role === 'rw' ? SKTM::where('rw', $user->rw)->get() : SKTM::all();

        return view('pelayanan.sktm.index', compact('data'));
    }

    public function create()
    {
        return view('pelayanan.sktm.create');
    }

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
            'keperluan' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'keperluan' => $request->keperluan,
            'tujuan' => $request->tujuan,
        ];

        $this->processImageUpload($request, 'foto_ktp', $data);
        $this->processImageUpload($request, 'foto_kk', $data);

        SKTM::create($data);

        return redirect()->route('home')->with('success', 'Data Telah Tersimpan, Harap Menunggu Validasi Dari Pihak RT');
    }

    public function show(string $id)
    {
        $data = SKTM::findOrfail($id);
        return view('pelayanan.sktm.show', compact('data'));
    }

    public function edit(string $id)
    {
        $data = SKTM::findOrfail($id);
        return view('pelayanan.sktm.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $model = SKTM::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['errors' => ['Data tidak ditemukan']], 404);
        }
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'keperluan' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        $data = [];

        $this->processImageUpload($request, 'foto_ktp', $data, $model);
        $this->processImageUpload($request, 'foto_kk', $data, $model);

        $model->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'keperluan' => $request->keperluan,
            'tujuan' => $request->tujuan,
            'foto_kk' => $data['foto_kk'] ?? $model->foto_kk,
            'foto_ktp' => $data['foto_ktp'] ?? $model->foto_ktp,
        ]);

        return redirect()->route('sktms.index')->with('success', 'Data Telah Tersimpan');
    }

    public function destroy(string $id)
    {
        try {
            $data = SKTM::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $this->deleteRelatedFiles($data);

        $data->delete();
        return redirect()->route('sktms.index')->with('success', 'Data Telah Terhapus');
    }

    private function deleteRelatedFiles($data)
    {
        $fileFields = ['foto_ktp', 'foto_kk'];

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

            if ($model && $model->$fieldName) {
                Storage::delete('public/img/' . $model->$fieldName);
            }

            $data[$fieldName] = $imageName;
        } elseif ($model && $model->$fieldName) {
            $data[$fieldName] = $model->$fieldName;
        }
    }
}
