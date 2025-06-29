@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4>Data Trafo Daya</h4>
            <nav>
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Trafo Daya</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('trafo-daya.create') }}" class="btn btn-primary">+ Tambah Trafo Daya</a>
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
                        <th>Gardu Induk</th>
                        <th>Nama</th>
                        <th>Setting Rele</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trafos as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->garduInduk->nama ?? '-' }}</td>
                            <td>{{ $t->nama }}</td>
                            <td>{{ $t->setting_rele }}</td>
                            <td>
                                <a href="{{ route('trafo-daya.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('trafo-daya.destroy', $t->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($trafos->isEmpty())
                        <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
