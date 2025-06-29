<?php

namespace App\Http\Controllers;

use App\Models\DataPenyulang;
use App\Models\Penyulang;
use Illuminate\Http\Request;

class DataPenyulangController extends Controller
{
    public function index()
    {
        $data = DataPenyulang::with('penyulang')->get();
        return view('data-penyulang.index', compact('data'));
    }

    public function create()
    {
        $penyulangs = Penyulang::all();
        return view('data-penyulang.form', compact('penyulangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_penyulang' => 'required|exists:penyulangs,id',
            'bulan'        => 'required|integer',
            'tahun'        => 'required|integer',
            'amp_siang'    => 'required|numeric',
            'teg_siang'    => 'required|numeric',
            'mw_siang'     => 'required|numeric',
            'amp_malam'    => 'required|numeric',
            'teg_malam'    => 'required|numeric',
            'mw_malam'     => 'required|numeric',
        ]);

        $kapasitor = 30;
        $validated['persen_siang'] = $kapasitor > 0 ? $validated['mw_siang'] / ($kapasitor * 0.9) * 100 : 0;
        $validated['persen_malam'] = $kapasitor > 0 ? $validated['mw_malam'] / ($kapasitor * 0.9) * 100 : 0;

        DataPenyulang::create($validated);

        return redirect()->route('data-penyulang.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $data = DataPenyulang::findOrFail($id);
        $penyulangs = Penyulang::all();

        return view('data-penyulang.form', compact('data', 'penyulangs'));
    }


    public function update(Request $request, DataPenyulang $data_penyulang)
    {
        $validated = $request->validate([
            'id_penyulang' => 'required|exists:penyulangs,id',
            'bulan'        => 'required|integer',
            'tahun'        => 'required|integer',
            'amp_siang'    => 'required|numeric',
            'teg_siang'    => 'required|numeric',
            'mw_siang'     => 'required|numeric',
            'amp_malam'    => 'required|numeric',
            'teg_malam'    => 'required|numeric',
            'mw_malam'     => 'required|numeric',
        ]);

        $kapasitor = 30;
        $validated['persen_siang'] = $kapasitor > 0 ? $validated['mw_siang'] / ($kapasitor * 0.9) * 100 : 0;
        $validated['persen_malam'] = $kapasitor > 0 ? $validated['mw_malam'] / ($kapasitor * 0.9) * 100 : 0;

        $data_penyulang->update($validated);

        return redirect()->route('data-penyulang.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(DataPenyulang $data_penyulang)
    {
        $data_penyulang->delete();
        return redirect()->route('data-penyulang.index')->with('success', 'Data berhasil dihapus');
    }
}
