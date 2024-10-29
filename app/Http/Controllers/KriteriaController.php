<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    // SIMPAN PERBANDINGAN
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

        // Inisialisasi matriks dengan nilai 1 di diagonal
        $matrix = [];
        $isAllOnes = true; // Flag untuk memeriksa apakah semua nilai adalah 1

        for ($i = 0; $i < $n; $i++) {
            $matrix[$i] = array_fill(0, $n, 1);
        }

        // Update matriks dengan nilai dari request (gunakan skala 1-9)
        foreach ($request->comparisons as $key => $value) {
            $indices = explode('_', $key);
            if (count($indices) < 2 || $indices[0] >= $n || $indices[1] >= $n) {
                continue;
            }

            $i = (int)$indices[0];
            $j = (int)$indices[1];

            $matrix[$i][$j] = (float)$value;
            $matrix[$j][$i] = ($value == 1) ? 1 : (1 / $matrix[$i][$j]);

            if ($value != 1) {
                $isAllOnes = false; // Jika ada nilai selain 1, set flag menjadi false
            }
        }

        // Jika semua nilai adalah 1, maka Priority Vector semuanya akan bernilai 1/n
        $columnSums = [];
        if ($isAllOnes) {
            $priorityVector = array_fill(0, $n, round(1 / $n, 5));
            $lambdaMax = $n;
            $consistencyIndex = 0;
            $consistencyRatio = 0;
            $columnSums = array_fill(0, $n, $n); // Mengisi jumlah kolom dengan nilai yang benar jika semua nilai adalah 1
        } else {
            // Hitung jumlah per kolom untuk normalisasi
            $columnSums = array_fill(0, $n, 0);
            foreach ($matrix as $i => $row) {
                foreach ($row as $j => $value) {
                    $columnSums[$j] += $value;
                }
            }

            // Normalisasi matriks dan hitung Priority Vector
            $priorityVector = [];
            foreach ($matrix as $i => $row) {
                $rowSum = 0;
                foreach ($row as $j => $value) {
                    $normalizedValue = $value / $columnSums[$j];
                    $matrix[$i][$j] = round($normalizedValue, 4);
                    $rowSum += $normalizedValue;
                }
                $priorityVector[$i] = round($rowSum / $n, 5);
            }

            // Hitung λ maks, CI, dan CR
            $lambdaMax = $this->calculateLambdaMax($matrix, $priorityVector);
            $consistencyIndex = ($lambdaMax - $n) / ($n - 1);
            $consistencyRatio = $this->calculateConsistencyRatio($consistencyIndex, $n);
        }

        return view('internal.pengajuan_pembangunan.lpmd.perbandingan.hasil', compact('matrix', 'priorityVector', 'columnSums', 'lambdaMax', 'consistencyIndex', 'consistencyRatio', 'kriteria'));
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
        $randomIndex = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45]; // Sampai ukuran 9

        if ($n > count($randomIndex)) {
            // Jika n lebih besar dari yang didukung randomIndex, tampilkan pesan error atau defaultkan
            return null; // atau nilai default lain jika diperlukan
        }

        return $consistencyIndex / $randomIndex[$n - 1];
    }

    // MEMBANDINGKAN KRITERIA
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
