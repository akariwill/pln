<?php

namespace App\Http\Controllers;

use App\Models\GarduInduk;
use Illuminate\Http\Request;

class GarduIndukController extends Controller
{
    public function index()
    {
        $gardus = GarduInduk::all();
        return view('gardu-induk.index', compact('gardus'));
    }

    public function create()
    {
        return view('gardu-induk.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        GarduInduk::create($validated);
        return redirect()->route('gardu-induk.index')->with('success', 'Gardu Induk berhasil ditambahkan.');
    }

    public function edit(GarduInduk $gardu_induk)
    {
        return view('gardu-induk.form', ['gardu' => $gardu_induk]);
    }

    public function update(Request $request, GarduInduk $gardu_induk)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $gardu_induk->update($validated);
        return redirect()->route('gardu-induk.index')->with('success', 'Gardu Induk berhasil diperbarui.');
    }

    public function destroy(GarduInduk $gardu_induk)
    {
        $gardu_induk->delete();
        return redirect()->route('gardu-induk.index')->with('success', 'Gardu Induk berhasil dihapus.');
    }
}
