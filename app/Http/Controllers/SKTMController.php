<?php

namespace App\Http\Controllers;

use App\Exports\SKTMExport;
use App\Models\SKTM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class SKTMController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek akses berdasarkan role user
        if ($user->role == 'kelurahan') {
            // Untuk user dengan role 'kelurahan', tampilkan hanya data yang tervalidasi
            $data = SKTM::where('validasi', 'tervalidasi')->get();
        } elseif ($user->role == 'rw') {
            // Untuk user dengan role 'rw', tampilkan data berdasarkan rw
            $data = SKTM::where('rw', $user->rw)->get();
        } elseif ($user->role == 'rt') {
            // Untuk user dengan role 'rt', tampilkan data berdasarkan rt
            $data = SKTM::where('rt', $user->rt)->get();
        } elseif ($user->role == 'admin') {
            // Untuk user dengan role 'admin', tampilkan semua data
            $data = SKTM::all();
        } else {
            // Jika role user tidak sesuai dengan akses yang diizinkan
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('pelayanan.sktm.index', compact('data'));
    }


    public function validateSKTM(Request $request, $id)
    {
        $data = SKTM::findOrFail($id);
        $data->validasi = 'tervalidasi';

        // Set waktu_validasi dengan datetime saat ini
        $data->waktu_validasi = now();

        // Ambil data Ketua RW dan Ketua RT sesuai dengan role dan nomor
        $ketuaRW = User::where('role', 'rw')->where('rw', $data->rw)->first();
        $ketuaRT = User::where('role', 'rt')->where('rt', $data->rt)->where('rw', $data->rw)->first();

        // Generate PDF dengan mengirimkan data SKTM, Ketua RW, dan Ketua RT
        $pdf = $this->generatePDF($data, $ketuaRW, $ketuaRT);

        // Save PDF and get filename
        $pdfName = $this->processPDFUpload($pdf, $id);

        // Save PDF name to 'surat_pengantar'
        $data->surat_pengantar = $pdfName;

        $data->save();

        // Kirim file PDF ke pengguna terkait
        $this->sendPDFToUser($data, 'surat_pengantar');

        return redirect()->route('sktms.index')->with('success', 'Pengajuan SKTM berhasil divalidasi dan PDF telah disimpan.');
    }

    private function sendPDFToUser(SKTM $sktm, $fileType)
    {
        // Cari pengguna berdasarkan nama lengkap dari SKTM
        $user = User::where('nama_lengkap', $sktm->nama_lengkap)->first();

        if ($user && $user->telegram_number) {
            // Tentukan nama file PDF berdasarkan jenis
            $pdfField = ($fileType === 'surat_pengantar') ? 'surat_pengantar' : 'produk';
            $pdfPath = storage_path('app/public/pdf/' . $sktm->$pdfField);

            // Kirim PDF ke Telegram
            $this->sendFileToTelegram($user->telegram_number, $pdfPath);
        }
    }

    private function sendFileToTelegram($chatId, $filePath)
    {
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot$telegramToken/sendDocument";

        // Pastikan file ada sebelum mengirim
        if (!file_exists($filePath)) {
            return; // Logika tambahan untuk menangani error
        }

        $response = Http::attach(
            'document',
            file_get_contents($filePath),
            basename($filePath)
        )->post($url, [
            'chat_id' => $chatId,
        ]);

        // Logika tambahan untuk menangani respons atau error
        if ($response->failed()) {
            // Tangani error
        }
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

    public function rejectFinalSKTM(Request $request, $id)
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

    public function finalSKTM(Request $request, $id)
    {
        // Cari data SKTM berdasarkan ID
        $data = SKTM::findOrFail($id);

        // Set nilai validasi menjadi 'final'
        $data->validasi = 'final';

        // Set masa berlaku dari request
        $data->masa_berlaku = $request->masa_berlaku;

        // Set waktu_finalisasi dengan datetime saat ini
        $data->waktu_finalisasi = now();

        // Kosongkan kolom keterangan jika ada nilainya
        if (!empty($data->keterangan)) {
            $data->keterangan = '';
        }

        // Simpan perubahan ke database
        $data->save();

        // Jika ada file produk yang diunggah, proses dan simpan
        if ($request->hasFile('produk')) {
            $file = $request->file('produk');
            $fileName = 'produk_' . $id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/pdf', $fileName);

            // Simpan nama file PDF ke field 'produk'
            $data->produk = $fileName;
            $data->save();
        }

        // Ambil data lurah berdasarkan role 'kelurahan'
        $lurah = User::where('role', 'kelurahan')->first();

        // Kirim file PDF ke pengguna terkait jika produk sudah diunggah
        if (!empty($data->produk)) {
            $this->sendPDFToUser($data, 'produk');
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('sktms.index')->with('success', 'Pengajuan SKTM berhasil difinalisasi.');
    }


    // public function finalSKTM(Request $request, $id)
    // {
    //     // Cari data SKTM berdasarkan ID
    //     $data = SKTM::findOrFail($id);

    //     // Set nilai validasi menjadi 'final'
    //     $data->validasi = 'final';

    //     // Set masa berlaku dari request
    //     $data->masa_berlaku = $request->masa_berlaku;

    //     // Set waktu_finalisasi dengan datetime saat ini
    //     $data->waktu_finalisasi = now();

    //     // Kosongkan kolom keterangan jika ada nilainya
    //     if (!empty($data->keterangan)) {
    //         $data->keterangan = '';
    //     }

    //     // Simpan perubahan ke database
    //     $data->save();

    //     // Ambil data lurah berdasarkan role 'kelurahan'
    //     $lurah = User::where('role', 'kelurahan')->first();

    //     // Generate PDF dengan mengirimkan data SKTM dan lurah
    //     $pdf = $this->generateProductPDF($data, $lurah);

    //     // Save PDF and get filename
    //     $pdfName = $this->processProductPDFUpload($pdf, $id);

    //     // Simpan nama file PDF ke field 'produk'
    //     $data->produk = $pdfName;

    //     // Simpan perubahan ke database
    //     $data->save();

    //     // Kirim file PDF ke pengguna terkait
    //     $this->sendPDFToUser($data, 'produk');

    //     // Redirect ke halaman index dengan pesan sukses
    //     return redirect()->route('sktms.index')->with('success', 'Pengajuan SKTM berhasil difinalisasi.');
    // }


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

    public function reportAllData()
    {
        return Excel::download(new SKTMExport(), 'data_sktm_all.xlsx');
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

    public function downloadProduct($id)
    {
        // Ambil data SKTM berdasarkan ID
        $data = SKTM::findOrFail($id);

        // Pastikan ada nama file PDF di field 'produk'
        if (!$data->produk) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        // Path file PDF di storage
        $pdfPath = storage_path('app/public/pdf/' . $data->produk);

        // Cek apakah file ada
        if (!file_exists($pdfPath)) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        // Unduh file PDF
        return response()->download($pdfPath);
    }


    private function generatePDF($data, $ketuaRW, $ketuaRT)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('report.surat_pengantar', compact('data', 'ketuaRW', 'ketuaRT'))->render());
        $dompdf->setPaper('F4', 'portrait');
        $dompdf->render();

        return $dompdf;
    }

    private function generateProductPDF($data, $lurah)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('report.surat_keterangan_tidak_mampu', compact('data', 'lurah'))->render());
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

    private function processProductPDFUpload($pdf, $id)
    {
        $pdfName = 'surat_keterangan_tidak_mampu' . $id . '.pdf';
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
        // Validasi inputan
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'foto_kk' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'foto_ktp' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'keperluan' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Pengecekan data apakah sesuai dengan data user yang sedang login
        $errors = [];
        if ($request->nama_lengkap !== $user->nama_lengkap) {
            $errors['nama_lengkap'] = 'Nama lengkap tidak sesuai dengan data user yang login.';
        }
        if ($request->jenis_kelamin !== $user->jenis_kelamin) {
            $errors['jenis_kelamin'] = 'Jenis kelamin tidak sesuai dengan data user yang login.';
        }
        if ($request->nik !== $user->nik) {
            $errors['nik'] = 'NIK tidak sesuai dengan data user yang login.';
        }
        if ($request->alamat !== $user->alamat) {
            $errors['alamat'] = 'Alamat tidak sesuai dengan data user yang login.';
        }
        if ($request->rt !== $user->rt) {
            $errors['rt'] = 'RT tidak sesuai dengan data user yang login.';
        }
        if ($request->rw !== $user->rw) {
            $errors['rw'] = 'RW tidak sesuai dengan data user yang login.';
        }

        // Jika ada kesalahan, kembalikan ke halaman sebelumnya dengan error
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Persiapkan data untuk disimpan
        $data = [
            'id_users' => $user->id, // Tambahkan ID user yang sedang login
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'keperluan' => $request->keperluan,
            'tujuan' => $request->tujuan,
        ];

        // Upload image jika tersedia
        $this->processImageUpload($request, 'foto_ktp', $data);
        $this->processImageUpload($request, 'foto_kk', $data);

        // Simpan data SKTM dan dapatkan instance yang baru dibuat
        $sktm = SKTM::create($data);

        // Kirim notifikasi ke user RT yang sesuai
        $this->sendTelegramNotification($sktm->rt, $sktm->rw, $sktm->nama_lengkap);

        return redirect()->route('home')->with('success', 'Data Telah Tersimpan, Harap Menunggu Validasi Dari Pihak RT');
    }


    private function sendTelegramNotification($rt, $rw, $namaLengkap)
    {
        // Find users with role 'rt' and matching rt and rw
        $users = User::where('role', 'rt')
            ->where('rt', $rt)
            ->where('rw', $rw)
            ->get();

        // Notification message
        $message = "Ada pengajuan SKTM baru dari $namaLengkap di RT $rt dan RW $rw. Harap segera divalidasi.";

        // Send message to all matched users
        foreach ($users as $user) {
            // Ensure telegram_number exists before sending message
            if ($user->telegram_number) {
                $this->sendMessageToTelegram($user->telegram_number, $message);
            }
        }
    }



    private function sendMessageToTelegram($chatId, $message)
    {
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot$telegramToken/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        // Logika tambahan untuk menangani respons atau error
        if ($response->failed()) {
            // Tangani error
        }
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
