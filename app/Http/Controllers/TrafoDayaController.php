<?php

namespace App\Http\Controllers;

use App\Models\TrafoDaya;
use App\Models\GarduInduk;
use Illuminate\Http\Request;

class TrafoDayaController extends Controller
{
    public function index()
    {
        $trafos = TrafoDaya::with('garduInduk')->get();
        return view('trafo-daya.index', compact('trafos'));
    }

    public function create()
    {
        $gardus = GarduInduk::all();
        return view('trafo-daya.form', compact('gardus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_gardu_induk' => 'required|exists:gardu_induks,id',
            'nama' => 'required|string|max:255',
            'kap' => 'required|string|max:255',
            'setting_rele' => 'required|numeric',
        ]);

        TrafoDaya::create($validated);
        return redirect()->route('trafo-daya.index')->with('success', 'Trafo Daya berhasil ditambahkan.');
    }

    public function edit(TrafoDaya $trafo_daya)
    {
        $gardus = GarduInduk::all();
        return view('trafo-daya.form', ['trafo' => $trafo_daya, 'gardus' => $gardus]);
    }

    public function update(Request $request, TrafoDaya $trafo_daya)
    {
        $validated = $request->validate([
            'id_gardu_induk' => 'required|exists:gardu_induks,id',
            'nama' => 'required|string|max:255',
            'kap' => 'required|string|max:255',
            'setting_rele' => 'required|numeric',
        ]);

        $trafo_daya->update($validated);
        return redirect()->route('trafo-daya.index')->with('success', 'Trafo Daya berhasil diperbarui.');
    }

    public function destroy(TrafoDaya $trafo_daya)
    {
        $trafo_daya->delete();
        return redirect()->route('trafo-daya.index')->with('success', 'Trafo Daya berhasil dihapus.');
    }
}
