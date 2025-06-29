<?php

namespace App\Http\Controllers;

use App\Models\Penyulang;
use App\Models\TrafoDaya;
use Illuminate\Http\Request;

class PenyulangController extends Controller
{
    public function index()
    {
        $penyulangs = Penyulang::with('trafoDaya')->get();
        return view('penyulang.index', compact('penyulangs'));
    }

    public function create()
    {
        $trafos = TrafoDaya::all();
        return view('penyulang.form', compact('trafos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_trafo_daya' => 'required|exists:trafo_dayas,id',
            'nama' => 'required|string|max:255',
            'kap' => 'required|string|max:255',
            'setting_rele' => 'required|integer',
        ]);

        Penyulang::create($validated);

        return redirect()->route('penyulang.index')->with('success', 'Penyulang berhasil ditambahkan.');
    }


    public function edit(Penyulang $penyulang)
    {
        $trafos = TrafoDaya::all();
        return view('penyulang.form', compact('penyulang', 'trafos'));
    }

    public function update(Request $request, Penyulang $penyulang)
    {
        $validated = $request->validate([
            'id_trafo_daya' => 'required|exists:trafo_dayas,id',
            'nama' => 'required|string|max:255',
            'kap' => 'required|string|max:255',
            'setting_rele' => 'required|integer',
        ]);

        $penyulang->update($validated);

        return redirect()->route('penyulang.index')->with('success', 'Penyulang berhasil diperbarui.');
    }


    public function destroy(Penyulang $penyulang)
    {
        $penyulang->delete();
        return redirect()->route('penyulang.index')->with('success', 'Penyulang berhasil dihapus.');
    }
}

