@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4>Data Penyulang</h4>
            <nav>
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Penyulang</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('data-penyulang.create') }}" class="btn btn-primary">+ Tambah Data</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-sm align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>Tanggal</th>
                        <th>Penyulang</th>
                        <th>Arus Siang</th>
                        <th>Tegangan Siang</th>
                        <th>MW Siang</th>
                        <th>% Siang</th>
                        <th>Arus Malam</th>
                        <th>Tegangan Malam</th>
                        <th>MW Malam</th>
                        <th>% Malam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    @forelse ($data as $key => $d)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $d->tanggal }}</td>
            <td>{{ $d->penyulang->nama }}</td>
            <td>{{ $d->amp_siang }}</td>
            <td>{{ $d->teg_siang }}</td>
            <td>{{ $d->mw_siang }}</td>
            <td>{{ number_format($d->persen_siang, 3) }}%</td> {{-- Mengubah format di sini --}}
            <td>{{ $d->amp_malam }}</td>
            <td>{{ $d->teg_malam }}</td>
            <td>{{ $d->mw_malam }}</td>
            <td>{{ number_format($d->persen_malam, 3) }}%</td> {{-- Mengubah format di sini --}}
            <td>
                <a href="{{ route('data-penyulang.edit', $d->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('data-penyulang.destroy', $d->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="12" class="text-center text-muted">Belum ada data.</td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection
