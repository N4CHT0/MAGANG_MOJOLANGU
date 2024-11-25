<?php

namespace App\Http\Controllers;

use App\Models\HasilPerbandinganAHP;
use App\Models\Kriteria;
use App\Models\Pembangunan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function hapusPerbandingan($id)
    {
        try {
            // Cari data berdasarkan ID
            $data = HasilPerbandinganAHP::findOrFail($id);

            // Hapus data
            $data->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('perbandingan.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi kesalahan
            return redirect()->route('perbandingan.index')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function showDetail($id)
    {
        $data = HasilPerbandinganAHP::findOrFail($id);

        // Decode perangkingan_pembangunan jika disimpan dalam format JSON
        $finalScores = $data->perangkingan_pembangunan;

        return view('internal.pengajuan_pembangunan.lpmd.detail', compact('data', 'finalScores'));
    }

    public function handleValidation(Request $request)
    {
        $option = $request->input('option');

        if (!$option) {
            return redirect()->back()->with('error', 'Pilihan tidak valid.');
        }

        $request->session()->forget('validated');
        $hasilPerbandingan = HasilPerbandinganAHP::latest()->first();

        // Jika status terakhir adalah 'final', buat data baru untuk setiap proses
        if (
            $hasilPerbandingan
            && $hasilPerbandingan->status === 'final'
            && !empty($hasilPerbandingan->file_pdf)
            && !empty($hasilPerbandingan->perangkingan_pembangunan)
            && !empty($hasilPerbandingan->input_nama)
        ) {

            // Buat data baru dengan ID baru untuk setiap proses
            $newData = HasilPerbandinganAHP::create([
                'data_perbandingan' => [], // Reset data perbandingan
                'status' => 'proses_pertama', // Mulai dari proses pertama
            ]);

            // Arahkan ke proses pertama dari data baru
            return redirect()->route('kriteria.perbandingan')->with('info', 'Status data terakhir adalah "final". Data baru berhasil dibuat dengan ID baru untuk proses pertama.');
        }

        // Lanjutkan logika berdasarkan opsi yang dipilih
        switch ($option) {
            case 'new_data':
                // Hapus data lama dan buat data baru
                if ($hasilPerbandingan) {
                    $hasilPerbandingan->delete();
                }
                HasilPerbandinganAHP::create(['data_perbandingan' => [], 'status' => 'proses_pertama']);
                return redirect()->route('kriteria.perbandingan')->with('info', 'Data baru berhasil dibuat. Mulai proses pertama.');

            case 'new_id_data':
                // Buat data baru tanpa menghapus data lama
                HasilPerbandinganAHP::create(['data_perbandingan' => [], 'status' => 'proses_pertama']);
                return redirect()->route('kriteria.perbandingan')->with('info', 'Data baru berhasil dibuat dengan ID baru.');

            case 'update_alternatif':
                if (!$hasilPerbandingan || $hasilPerbandingan->status === 'proses_pertama') {
                    return redirect()->route('validate.process')->with('error', 'Proses kedua belum bisa dilanjutkan. Mulai dari proses pertama.');
                }
                return redirect()->route('nilai.perbandingan')->with('info', 'Silakan lanjutkan proses perbandingan alternatif.');

            case 'update_kriteria':
                if (!$hasilPerbandingan || $hasilPerbandingan->status === 'proses_kedua') {
                    return redirect()->route('validate.process')->with('error', 'Proses pertama belum bisa diperbarui. Mulai dari proses pertama.');
                }
                return redirect()->route('kriteria.perbandingan')->with('info', 'Silakan ubah nilai perbandingan kriteria.');

            case 'overwrite':
                if ($hasilPerbandingan) {
                    $hasilPerbandingan->update([
                        'data_perbandingan' => [], // Reset data
                        'status' => 'proses_pertama', // Mulai kembali dari proses pertama
                    ]);
                }
                return redirect()->route('kriteria.perbandingan')->with('info', 'Data berhasil ditimpa. Mulai kembali dari proses pertama.');

            default:
                return redirect()->back()->with('error', 'Pilihan tidak valid.');
        }
    }



    public function validateProcess(Request $request)
    {
        $hasilPerbandingan = HasilPerbandinganAHP::latest()->first();

        if (!$hasilPerbandingan) {
            $request->session()->forget('validated');
            return redirect()->route('kriteria.perbandingan')->with('info', 'Tidak ada data sebelumnya. Mulai proses pertama.');
        }

        $status = $hasilPerbandingan->status ?? 'proses_pertama';
        $options = [];

        if ($status === 'proses_pertama') {
            $options = [
                'new_data' => 'Buat sebagai data baru (reset dan mulai proses pertama)',
                'new_id_data' => 'Buat sebagai data baru dengan ID baru',
                'overwrite' => 'Timpa data saat ini (proses pertama)',
            ];
        } elseif ($status === 'proses_kedua') {
            $options = [
                'new_data' => 'Buat sebagai data baru (reset dan mulai proses pertama)',
                'new_id_data' => 'Buat sebagai data baru dengan ID baru',
                'update_alternatif' => 'Lanjutkan proses perbandingan alternatif (proses kedua)',
            ];
        } elseif ($status === 'proses_akhir') {
            $options = [
                'new_data' => 'Buat sebagai data baru (reset dan mulai proses pertama)',
                'new_id_data' => 'Buat sebagai data baru dengan ID baru',
                'update_alternatif' => 'Ubah nilai proses kedua (perbandingan alternatif)',
                'update_kriteria' => 'Ubah nilai proses pertama (perbandingan kriteria)',
                'overwrite' => 'Timpa data saat ini (proses akhir)', // Tambahkan opsi overwrite di sini
            ];
        }

        $request->session()->put('validated', true);

        return view('internal.pengajuan_pembangunan.lpmd.validasi.proses', [
            'options' => $options,
            'hasilPerbandingan' => $hasilPerbandingan,
        ]);
    }



    public function downloadPdf($id)
    {
        $data = HasilPerbandinganAHP::findOrFail($id);

        // Pastikan file PDF ada sebelum mencoba mengunduh
        $path = storage_path('app/public/pdf/' . $data->file_pdf);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        return response()->download($path, $data->file_pdf);
    }


    public function showRankingData()
    {
        $pembangunan = HasilPerbandinganAHP::all();
        return view('internal.pengajuan_pembangunan.lpmd.index', compact('pembangunan'));
    }


    private function sendToLurah(Request $request)
    {
        // Ambil semua pengguna dengan role 'kelurahan'
        $users = User::where('role', 'kelurahan')->get();

        // Nama file PDF dan path lengkap
        $fileName = $request->file_pdf . '.pdf';
        $filePath = storage_path('app/public/pdf/' . $fileName);

        // Pastikan file ada sebelum mengirim
        if (!file_exists($filePath)) {
            return; // Tambahkan logika error handling jika file tidak ditemukan
        }

        // Pesan yang dikirim bersama file PDF
        $message = "Berikut laporan perbandingan ranking terbaru.";

        // Kirim PDF ke setiap user dengan telegram_number
        foreach ($users as $user) {
            if ($user->telegram_number) {
                // Kirim file PDF ke user melalui Telegram
                $this->sendFileToTelegram($user->telegram_number, $filePath);
                // Kirim pesan teks opsional jika ingin menyertakan pesan terpisah
                $this->sendMessageToTelegram($user->telegram_number, $message);
            }
        }
    }

    public function saveRankingPdf(Request $request)
    {
        $request->validate([
            'input_nama' => 'required|string|max:255',
            'file_pdf' => 'required|string|max:255',
        ]);

        $hasilPerbandingan = HasilPerbandinganAhp::latest()->first();
        $fileName = $request->file_pdf . '.pdf';
        $path = storage_path('app/public/pdf/' . $fileName);

        // Generate PDF dengan library seperti DomPDF atau Snappy (wkhtmltopdf)
        $pdf = FacadePdf::loadView('internal.pengajuan_pembangunan.lpmd.perbandingan.pdf_report', [
            'finalScores' => $hasilPerbandingan->perangkingan_pembangunan,
            'inputNama' => $request->input_nama
        ]);
        $pdf->save($path);

        // Update model dengan nama file dan nama input
        $hasilPerbandingan->update([
            'file_pdf' => $fileName,
            'input_nama' => $request->input_nama,
            'status' => 'final'
        ]);

        // Panggil fungsi untuk mengirim PDF ke Telegram lurah
        $this->sendToLurah($request);

        return redirect()->back()->with('success', 'Laporan PDF berhasil disimpan dan dikirim ke Lurah!');
    }

    public function calculateFinalScore()
    {
        $hasilPerbandingan = HasilPerbandinganAHP::latest()->first();

        if ($hasilPerbandingan && $hasilPerbandingan->status === 'final') {
            $hasilPerbandingan = HasilPerbandinganAHP::create([
                'data_perbandingan' => [],
                'status' => 'proses_akhir',
            ]);
        }

        // Jika data sudah dalam status proses_akhir, arahkan ke halaman validasi
        if ($hasilPerbandingan && $hasilPerbandingan->status === 'proses_akhir') {
            return redirect()->route('validate.process')->with('info', 'Proses akhir sudah selesai. Validasi diperlukan untuk melanjutkan.');
        }

        if (!$hasilPerbandingan || $hasilPerbandingan->status !== 'proses_kedua') {
            return redirect()->back()->with('error', 'Proses kedua belum selesai. Lanjutkan proses kedua terlebih dahulu.');
        }

        $dataPerbandingan = $hasilPerbandingan->data_perbandingan;
        $bobotKriteria = $dataPerbandingan['perbandingan_kriteria']['priority_vector'];
        $alternatif = Pembangunan::all();
        $kriteria = Kriteria::all();

        $finalScores = [];
        $matrixData = []; // Array untuk menyimpan matriks perkalian

        foreach ($alternatif as $alt) {
            $totalScore = 0;
            $row = [
                'alternatif' => $alt->nama, // Tambahkan nama alternatif di sini
            ]; // Untuk menyimpan data baris pada matrixData

            foreach ($kriteria as $krit) {
                $kriteriaId = $krit->id;
                $bobot = $bobotKriteria[$kriteriaId - 1];
                $nilaiNormalisasi = $dataPerbandingan['perbandingan_alternatif'][$kriteriaId]['priorityVector'][$alt->id];
                $perkalian = $nilaiNormalisasi * $bobot;

                $row[] = round($perkalian, 3);
                $totalScore += $perkalian;
            }

            // Tambahkan hasil perkalian ke matrixData
            $row['total'] = round($totalScore, 3); // Tambahkan kolom total
            $matrixData[] = $row;

            $finalScores[] = [
                'alternatif' => $alt->nama,
                'score' => round($totalScore, 3)
            ];
        }

        usort($finalScores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $topPriority = $finalScores[0];

        // Simpan hasil perangkingan dan ubah status ke proses akhir
        $hasilPerbandingan->update([
            'perangkingan_pembangunan' => $finalScores,
            'status' => 'proses_akhir', // Status proses akhir
        ]);

        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.hasil_prioritas', [
            'finalScores' => $finalScores,
            'topPriority' => $topPriority,
            'matrixData' => $matrixData, // Tambahkan matrixData ke view
        ]);
    }




    public function storeComparisonValue(Request $request)
    {
        $hasilPerbandingan = HasilPerbandinganAHP::latest()->first();

        // Jika data terakhir berstatus 'final', buat data baru
        if ($hasilPerbandingan && $hasilPerbandingan->status === 'final') {
            $hasilPerbandingan = HasilPerbandinganAHP::create([
                'data_perbandingan' => [],
                'status' => 'proses_kedua',
            ]);
        }

        // Jika data sudah ada dan statusnya proses_kedua, arahkan ke halaman validasi
        if ($hasilPerbandingan && $hasilPerbandingan->status === 'proses_kedua' && !empty($hasilPerbandingan->data_perbandingan['perbandingan_alternatif'])) {
            return redirect()->route('validate.process')->with('info', 'Proses kedua sudah selesai. Silakan validasi untuk melanjutkan.');
        }

        if (!$hasilPerbandingan || $hasilPerbandingan->status !== 'proses_pertama') {
            return redirect()->back()->with('error', 'Proses pertama belum selesai. Mulai dari proses pertama.');
        }

        $kriteria = Kriteria::all();
        $alternatif = Pembangunan::all();

        $dataPerbandingan = $hasilPerbandingan->data_perbandingan;
        if (!isset($dataPerbandingan['perbandingan_alternatif'])) {
            $dataPerbandingan['perbandingan_alternatif'] = [];
        }

        $finalNormalizedMatrix = []; // Untuk hasil normalisasi akhir (alternatif)

        foreach ($kriteria as $k) {
            $matrix = [];

            foreach ($alternatif as $a1) {
                foreach ($alternatif as $a2) {
                    if ($a1->id < $a2->id) {
                        $value = $request->input("values.{$k->id}.{$a1->id}_{$a2->id}") ?: 1;
                        $matrix[$a1->id][$a2->id] = $value;
                        $matrix[$a2->id][$a1->id] = 1 / $value;
                    } elseif ($a1->id == $a2->id) {
                        $matrix[$a1->id][$a2->id] = 1; // Diagonal utama
                    }
                }
            }

            // Hitung jumlah kolom untuk normalisasi
            $columnSums = [];
            foreach ($alternatif as $a) {
                $columnSums[$a->id] = array_sum(array_column($matrix, $a->id));
            }

            // Normalisasi Matriks
            $normalizedMatrix = [];
            $priorityVector = [];
            foreach ($alternatif as $a1) {
                $rowSum = 0;
                foreach ($alternatif as $a2) {
                    $normalizedValue = $matrix[$a1->id][$a2->id] / $columnSums[$a2->id];
                    $normalizedMatrix[$a1->id][$a2->id] = round($normalizedValue, 3);
                    $rowSum += $normalizedValue;
                }
                $priorityVector[$a1->id] = round($rowSum / count($alternatif), 3);
            }

            // Tambahkan hasil prioritas alternatif ke tabel hasil akhir
            foreach ($priorityVector as $altId => $value) {
                $finalNormalizedMatrix[$altId][$k->id] = $value;
            }

            $dataPerbandingan['perbandingan_alternatif'][$k->id] = [
                'matrix' => $matrix,
                'normalizedMatrix' => $normalizedMatrix,
                'priorityVector' => $priorityVector,
                'columnSums' => $columnSums,
            ];
        }

        // Simpan hasil ke database dan ubah status ke proses kedua
        $hasilPerbandingan->update([
            'data_perbandingan' => $dataPerbandingan,
            'status' => 'proses_kedua', // Status proses kedua
        ]);

        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.hasil_nilai', [
            'dataPerbandinganAlternatif' => $dataPerbandingan['perbandingan_alternatif'],
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'finalNormalizedMatrix' => $finalNormalizedMatrix, // Hasil normalisasi alternatif
        ]);
    }





    public function compareValue()
    {
        $kriteria = Kriteria::all();
        $alternatif = Pembangunan::all();

        $comparisons = [];
        foreach ($kriteria as $k) {
            foreach ($alternatif as $a) {
                $comparisons[] = [
                    'kriteria' => $k,
                    'alternatif' => $a,
                ];
            }
        }

        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.nilai', compact('comparisons', 'kriteria', 'alternatif'));
    }

    // Simpan Perbandingan Kriteria (Proses Pertama)
    public function storeComparison(Request $request)
    {
        $request->session()->forget('validated'); // Hapus session validasi
        $hasilPerbandingan = HasilPerbandinganAHP::latest()->first();

        // Jika data tidak ditemukan, buat data baru
        if (!$hasilPerbandingan) {
            $hasilPerbandingan = HasilPerbandinganAHP::create([
                'data_perbandingan' => [],
                'status' => 'proses_pertama',
            ]);
        }

        // Jika data sudah ada dan statusnya proses_pertama, arahkan ke halaman validasi
        if ($hasilPerbandingan->status === 'proses_pertama' && !empty($hasilPerbandingan->data_perbandingan['perbandingan_kriteria'])) {
            return redirect()->route('validate.process')->with('info', 'Proses pertama sudah selesai. Silakan validasi untuk melanjutkan.');
        }

        if (is_null($request->comparisons)) {
            return redirect()->back()->with('error', 'Tidak ada data perbandingan yang diterima.');
        }

        $kriteria = Kriteria::all();
        $n = count($kriteria);

        if ($n === 0) {
            return redirect()->back()->with('error', 'Data kriteria tidak ditemukan.');
        }

        // Inisialisasi matriks perbandingan berpasangan
        $matrix = array_fill(0, $n, array_fill(0, $n, 1));
        foreach ($request->comparisons as $key => $value) {
            $indices = explode('_', $key);
            if (count($indices) < 2) {
                continue;
            }
            $i = (int)$indices[0] - 1;
            $j = (int)$indices[1] - 1;
            $matrix[$i][$j] = (float)$value;
            $matrix[$j][$i] = ($value == 1) ? 1 : (1 / (float)$value);
        }

        $initialMatrix = $matrix;
        $columnSums = array_map('array_sum', array_map(null, ...$matrix));

        $normalizedMatrix = [];
        $priorityVector = [];
        foreach ($matrix as $i => $row) {
            $rowSum = 0;
            foreach ($row as $j => $value) {
                $normalizedValue = $value / $columnSums[$j];
                $normalizedMatrix[$i][$j] = round($normalizedValue, 4);
                $rowSum += $normalizedValue;
            }
            $priorityVector[$i] = round($rowSum / $n, 5);
        }

        $lambdaMax = $this->calculateLambdaMax($matrix, $priorityVector);
        $consistencyIndex = ($lambdaMax - $n) / ($n - 1);
        $consistencyRatio = $this->calculateConsistencyRatio($consistencyIndex, $n);

        $dataPerbandingan = [
            'perbandingan_kriteria' => [
                'initial_matrix' => $initialMatrix,
                'normalized_matrix' => $normalizedMatrix,
                'priority_vector' => $priorityVector,
                'lambda_max' => $lambdaMax,
                'consistency_index' => $consistencyIndex,
                'consistency_ratio' => $consistencyRatio,
            ]
        ];

        $hasilPerbandingan->update([
            'data_perbandingan' => $dataPerbandingan,
            'status' => 'proses_pertama',
        ]);

        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.hasil', [
            'initialMatrix' => $initialMatrix,
            'matrix' => $normalizedMatrix,
            'priorityVector' => $priorityVector,
            'columnSums' => $columnSums,
            'lambdaMax' => $lambdaMax,
            'consistencyIndex' => $consistencyIndex,
            'consistencyRatio' => $consistencyRatio,
            'kriteria' => $kriteria,
        ]);
    }

    public function compareCriteria()
    {
        // Ambil semua kriteria dari database
        $kriteria = Kriteria::all();

        // Buat kombinasi perbandingan kriteria
        $comparisons = [];
        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = $i + 1; $j < count($kriteria); $j++) {
                $comparisons[] = [
                    'kriteria1' => $kriteria[$i],
                    'kriteria2' => $kriteria[$j],
                ];
            }
        }

        // Tampilkan view perbandingan kriteria dengan data
        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.kriteria', compact('comparisons', 'kriteria'));
    }

    private function calculateLambdaMax($matrix, $priorityVector)
    {
        $n = count($matrix);
        $lambdaMax = 0;

        foreach ($matrix as $i => $row) {
            $lambdaMax += array_sum(array_map(function ($value, $pv) {
                return $value * $pv;
            }, $row, $priorityVector));
        }

        return $lambdaMax / $n;
    }

    private function calculateConsistencyRatio($consistencyIndex, $n)
    {
        $randomIndex = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59]; // Sampai ukuran 14

        if ($n > count($randomIndex)) {
            // Jika n lebih besar dari yang didukung randomIndex, tampilkan pesan error atau defaultkan
            return null; // atau nilai default lain jika diperlukan
        }

        return $consistencyIndex / $randomIndex[$n - 1];
    }

    // UNTUK MENAMPILKAN DATA KRITERIA
    public function index()
    {
        $data = Kriteria::all();

        return view('internal.pengajuan_pembangunan.lpmd.kriteria', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Kriteria::create($validated);

        return response()->json(['message' => 'Kriteria berhasil ditambahkan!']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update($validated);

        return response()->json(['message' => 'Kriteria berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        Kriteria::destroy($id);
        return response()->json(['message' => 'Kriteria berhasil dihapus!']);
    }
}
