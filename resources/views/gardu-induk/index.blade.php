@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4>Data Gardu Induk</h4>
            <nav>
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Gardu Induk</li>
                </ol>
            </nav>
        </div>

        @role('admin')
        <a href="{{ route('gardu-induk.create') }}" class="btn btn-primary">+ Tambah Gardu Induk</a>
        @endrole
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
                        @role('admin')
                        <th>Aksi</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach($gardus as $g)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $g->nama }}</td>
                        @role('admin')
                        <td>
                            <a href="{{ route('gardu-induk.edit', $g->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('gardu-induk.destroy', $g->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                    @if($gardus->isEmpty())
                    <tr>
                        <td colspan="@role('admin')3@else2@endrole" class="text-center">Belum ada data.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection