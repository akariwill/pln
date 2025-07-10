@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ isset($gardu) ? 'Edit' : 'Tambah' }} Gardu Induk</h4>
        <a href="{{ route('gardu-induk.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($gardu) ? route('gardu-induk.update', $gardu->id) : route('gardu-induk.store') }}" method="POST">
                @csrf
                @if(isset($gardu)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Nama Gardu Induk</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $gardu->nama ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
