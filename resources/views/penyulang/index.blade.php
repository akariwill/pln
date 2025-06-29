@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4>Data Penyulang</h4>
            <nav>
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Penyulang</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('penyulang.create') }}" class="btn btn-primary">+ Tambah Penyulang</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>ID Trafo</th>
                        <th>Setting Rele</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penyulangs as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->id_trafo_daya }}</td>
                            <td>{{ $p->kap }}</td>
                            <td>{{ $p->setting_rele }}</td>
                            <td>
                                <a href="{{ route('penyulang.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('penyulang.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($penyulangs->isEmpty())
                        <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
