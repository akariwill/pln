@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ isset($trafo) ? 'Edit' : 'Tambah' }} Trafo Daya</h4>
        <a href="{{ route('trafo-daya.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($trafo) ? route('trafo-daya.update', $trafo->id) : route('trafo-daya.store') }}" method="POST">
                @csrf
                @if(isset($trafo)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Gardu Induk</label>
                    <select name="id_gardu_induk" class="form-select" required>
                        @foreach ($gardus as $g)
                            <option value="{{ $g->id }}" {{ old('id_gardu_induk', $trafo->id_gardu_induk ?? '') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Trafo</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $trafo->nama ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Setting Rele</label>
                    <input type="number" name="setting_rele" class="form-control" value="{{ old('setting_rele', $trafo->setting_rele ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
