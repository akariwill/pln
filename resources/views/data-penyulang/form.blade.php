@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ isset($data) ? 'Edit' : 'Tambah' }} Data Penyulang</h4>
        <a href="{{ route('data-penyulang.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($data) ? route('data-penyulang.update', $data->id) : route('data-penyulang.store') }}" method="POST">
                @csrf
                @if(isset($data)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Penyulang</label>
                    <select name="id_penyulang" class="form-control" required>
                        @foreach ($penyulangs as $p)
                            <option value="{{ $p->id }}" {{ old('id_penyulang', $data->id_penyulang ?? '') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $data->tanggal ?? '') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Arus Siang</label>
                        <input type="number" step="0.01" name="amp_siang" class="form-control" value="{{ old('amp_siang', $data->amp_siang ?? '') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tegangan Siang</label>
                        <input type="number" step="0.01" name="teg_siang" class="form-control" value="{{ old('teg_siang', $data->teg_siang ?? '') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">MW Siang</label>
                        <input type="number" step="0.01" name="mw_siang" class="form-control" value="{{ old('mw_siang', $data->mw_siang ?? '') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Arus Malam</label>
                        <input type="number" step="0.01" name="amp_malam" class="form-control" value="{{ old('amp_malam', $data->amp_malam ?? '') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Tegangan Malam</label>
                        <input type="number" step="0.01" name="teg_malam" class="form-control" value="{{ old('teg_malam', $data->teg_malam ?? '') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">MW Malam</label>
                        <input type="number" step="0.01" name="mw_malam" class="form-control" value="{{ old('mw_malam', $data->mw_malam ?? '') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
