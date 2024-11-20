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
            'status' => 'Final'
        ]);

        // Panggil fungsi untuk mengirim PDF ke Telegram lurah
        $this->sendToLurah($request);

        return redirect()->back()->with('success', 'Laporan PDF berhasil disimpan dan dikirim ke Lurah!');
    }

    public function calculateFinalScore()
    {
        $hasilPerbandingan = HasilPerbandinganAhp::latest()->first();

        if (!$hasilPerbandingan) {
            return redirect()->back()->with('error', 'Data perbandingan kriteria belum tersedia.');
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

        // Simpan hasil perangkingan ke dalam field perangkingan_pembangunan
        $hasilPerbandingan->update([
            'perangkingan_pembangunan' => $finalScores
        ]);

        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.hasil_prioritas', [
            'finalScores' => $finalScores,
            'topPriority' => $topPriority,
            'matrixData' => $matrixData, // Tambahkan matrixData ke view
        ]);
    }

    public function storeComparisonValue(Request $request)
    {
        $kriteria = Kriteria::all();
        $alternatif = Pembangunan::all();
        $hasilPerbandingan = HasilPerbandinganAhp::latest()->first();

        if (!$hasilPerbandingan) {
            return redirect()->back()->with('error', 'Data perbandingan kriteria belum tersedia.');
        }

        $dataPerbandingan = $hasilPerbandingan->data_perbandingan;
        if (!isset($dataPerbandingan['perbandingan_alternatif'])) {
            $dataPerbandingan['perbandingan_alternatif'] = [];
        }

        foreach ($kriteria as $k) {
            $matrix = [];
            foreach ($alternatif as $a1) {
                foreach ($alternatif as $a2) {
                    if ($a1->id < $a2->id) {
                        $selected = $request->input("comparisons.{$k->id}.{$a1->id}_{$a2->id}");
                        $value = $request->input("values.{$k->id}.{$a1->id}_{$a2->id}");
                        if ($selected == "1") {
                            // Pastikan nilai bukan nol atau kosong sebelum digunakan
                            $value = $value ? $value : 1; // Set nilai default jika kosong
                            $matrix[$a1->id][$a2->id] = $value;
                            $matrix[$a2->id][$a1->id] = 1 / $value;
                        } else {
                            // Cek jika $value adalah nol atau kosong untuk menghindari pembagian dengan nol
                            $value = $value ? $value : 1; // Set nilai default jika kosong
                            $matrix[$a1->id][$a2->id] = 1 / $value;
                            $matrix[$a2->id][$a1->id] = $value;
                        }


                        $matrix[$a1->id][$a2->id] = $selected == "1" ? $value : 1 / $value;
                        $matrix[$a2->id][$a1->id] = $selected == "1" ? 1 / $value : $value;
                    } else if ($a1->id == $a2->id) {
                        $matrix[$a1->id][$a2->id] = 1;
                    }
                }
            }

            // Step 1: Hitung jumlah kolom untuk setiap kolom matriks alternatif
            $columnSums = [];
            foreach ($alternatif as $a) {
                $columnSums[$a->id] = array_sum(array_column($matrix, $a->id));
            }

            // Step 2: Normalisasi matriks alternatif berdasarkan jumlah kolom yang telah dihitung
            $normalizedMatrix = [];
            $priorityVector = [];
            foreach ($alternatif as $a1) {
                $rowSum = 0;
                foreach ($alternatif as $a2) {
                    $normalizedValue = $matrix[$a1->id][$a2->id] / $columnSums[$a2->id];
                    $normalizedMatrix[$a1->id][$a2->id] = round($normalizedValue, 3);
                    $rowSum += $normalizedValue;
                }
                $priorityVector[$a1->id] = round($rowSum / count($alternatif), 5);
            }

            // Step 3: Simpan hasil perbandingan alternatif untuk kriteria ini
            $dataPerbandingan['perbandingan_alternatif'][$k->id] = [
                'matrix' => $matrix,
                'normalizedMatrix' => $normalizedMatrix,
                'priorityVector' => $priorityVector,
                'columnSums' => $columnSums
            ];
        }

        // Menghitung Hasil Normalisasi Akhir untuk Setiap Alternatif
        $finalNormalizedResults = [];
        foreach ($alternatif as $alt) {
            $finalNormalizedResults[$alt->id] = [];
        }

        foreach ($dataPerbandingan['perbandingan_alternatif'] as $kriteriaId => $data) {
            foreach ($data['priorityVector'] as $altId => $priority) {
                $finalNormalizedResults[$altId][$kriteriaId] = $priority;
            }
        }

        // Simpan hasil perbandingan yang sudah diperbarui
        $hasilPerbandingan->update([
            'data_perbandingan' => $dataPerbandingan,
        ]);

        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.hasil_nilai', [
            'dataPerbandinganAlternatif' => $dataPerbandingan['perbandingan_alternatif'],
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'finalNormalizedResults' => $finalNormalizedResults
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

    public function storeComparison(Request $request)
    {
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

        // Hitung jumlah setiap kolom untuk normalisasi
        $columnSums = array_map('array_sum', array_map(null, ...$matrix));

        // Normalisasi matriks dan hitung priority vector
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

        // Hitung λ maks, CI, dan CR
        $lambdaMax = $this->calculateLambdaMax($matrix, $priorityVector);
        $consistencyIndex = ($lambdaMax - $n) / ($n - 1);
        $consistencyRatio = $this->calculateConsistencyRatio($consistencyIndex, $n);

        // Gabungkan hasil perbandingan kriteria dalam struktur JSON
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

        // Simpan data sebagai JSON
        HasilPerbandinganAhp::create([
            'data_perbandingan' => $dataPerbandingan,
        ]);

        // Mengirim data ke view
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
