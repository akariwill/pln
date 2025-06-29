<?php

namespace App\Http\Controllers;

use App\Models\DataPenyulang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->toDateString();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalBebanHariIni = DataPenyulang::whereDate('created_at', $today)
            ->sum(DB::raw('mw_siang + mw_malam'));

        $totalBebanBulanIni = DataPenyulang::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->sum(DB::raw('mw_siang + mw_malam'));

        $totalPenyulang = DataPenyulang::distinct('id_penyulang')->count('id_penyulang');

        $last = DataPenyulang::latest('created_at')->first();
        $prediksiBesok = $last ? ($last->mw_siang + $last->mw_malam) : 0;

        $grafik = DataPenyulang::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(mw_siang + mw_malam) as total_beban')
            )
            ->whereYear('created_at', $tahunIni)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $grafikBulan = [];
        $grafikData = [];
        foreach ($grafik as $g) {
            $grafikBulan[] = Carbon::create()->month($g->bulan)->format('M');
            $grafikData[] = round($g->total_beban, 2);
        }

        $riwayatPrediksi = DataPenyulang::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(mw_siang) as total_siang'),
                DB::raw('SUM(mw_malam) as total_malam')
            )
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get();

        $labelPrediksi = [];
        $dataPrediksiSiang = [];
        $dataPrediksiMalam = [];

        foreach ($riwayatPrediksi as $r) {
            $labelPrediksi[] = Carbon::parse($r->tanggal)->format('d M');
            $dataPrediksiSiang[] = round($r->total_siang, 2);
            $dataPrediksiMalam[] = round($r->total_malam, 2);
        }

        return view('dashboard', compact(
            'totalBebanHariIni',
            'totalBebanBulanIni',
            'totalPenyulang',
            'prediksiBesok',
            'grafikBulan',
            'grafikData',
            'labelPrediksi',
            'dataPrediksiSiang',
            'dataPrediksiMalam'
        ));
    }
}
