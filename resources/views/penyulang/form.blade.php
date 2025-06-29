@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ isset($penyulang) ? 'Edit' : 'Tambah' }} Data Penyulang</h4>
        <a href="{{ route('penyulang.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($penyulang) ? route('penyulang.update', $penyulang->id) : route('penyulang.store') }}" method="POST">
                @csrf
                @if(isset($penyulang)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Nama Penyulang</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $penyulang->nama ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trafo Daya</label>
                    <select name="id_trafo_daya" class="form-select" required>
                        @foreach($trafos as $trafo)
                            <option value="{{ $trafo->id }}"
                                {{ (old('id_trafo_daya', $penyulang->id_trafo_daya ?? '') == $trafo->id) ? 'selected' : '' }}>
                                {{ $trafo->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Setting Rele</label>
                    <input type="number" name="setting_rele" class="form-control" value="{{ old('setting_rele', $penyulang->setting_rele ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
