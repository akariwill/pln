<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Penyulang;
use App\Models\DataPenyulang;

class PrediksiController extends Controller
{
    public function index()
    {
        $penyulangs = Penyulang::all();
        return view('prediksi.index', compact('penyulangs'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'penyulang' => 'required|string',
        ]);

        $penyulang = Penyulang::with(['trafoDaya.garduInduk'])
            ->where('nama', $request->penyulang)
            ->first();

        if (!$penyulang) {
            return redirect()->route('prediksi.index')
                ->with('error', 'Penyulang tidak ditemukan.');
        }

        $trafo = optional($penyulang->trafoDaya);
        $gardu = optional($trafo->garduInduk);

        $histori = DataPenyulang::where('id_penyulang', $penyulang->id)
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get()
            ->reverse() 
            ->map(function ($item) use ($penyulang, $trafo, $gardu) {
                return [
                    'gardu_induk' => optional($gardu)->nama ?? 'GI Default',
                    'trafo_daya' => optional($trafo)->nama ?? 'Trafo Default',
                    'penyulang' => $penyulang->nama,
                    'amp_siang' => $item->amp_siang,
                    'teg_siang' => $item->teg_siang,
                    'mw_siang' => $item->mw_siang,
                    'amp_malam' => $item->amp_malam,
                    'teg_malam' => $item->teg_malam,
                    'mw_malam' => $item->mw_malam,
                ];
            })->toArray();
            \Log::info('Jumlah histori:', ['count' => count($histori)]);
            \Log::info('Isi histori:', $histori);


        if (empty($histori)) {
            return redirect()->route('prediksi.index')
                ->with('error', 'Data histori kosong, tidak bisa dikirim ke server.');
        }

        if (count($histori) < 5) {
            return redirect()->route('prediksi.index')
                ->with('error', 'Data histori tidak mencukupi untuk melakukan prediksi.');
        }

        try {
            $response = Http::post('http://127.0.0.1:5000/predict', [
                'histori' => $histori
            ]);

            if ($response->successful() && $response->json('status') === 'ok') {
                return redirect()->route('prediksi.index')
                    ->with('result', $response->json())
                    ->with('penyulang', $request->penyulang);
            } else {
                return redirect()->route('prediksi.index')
                    ->with('error', $response->json('message') ?? 'Gagal mendapatkan prediksi dari server.');
            }
        } catch (\Exception $e) {
            return redirect()->route('prediksi.index')
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }
}

