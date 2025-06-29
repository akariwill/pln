<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard PLN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #343a40;
        }
        .content-area {
            padding: 2rem;
            background-color: #f8f9fa;
            flex-grow: 1;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h5 class="text-white">PLN Admin</h5>
        <hr class="bg-light">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home me-2"></i>Dashboard</a>
        <div class="mt-3 mb-1 text-uppercase small text-muted">Manajemen Data</div>
        <a href="{{ route('gardu-induk.index') }}"><i class="fas fa-bolt me-2"></i>Gardu Induk</a>
        <a href="{{ route('trafo-daya.index') }}"><i class="fas fa-plug me-2"></i>Trafo Daya</a>
        <a href="{{ route('penyulang.index') }}"><i class="fas fa-broadcast-tower me-2"></i>Penyulang</a>
        <a href="{{ route('data-penyulang.index') }}"><i class="fas fa-database me-2"></i>Data Penyulang</a>
        <hr class="bg-light">
        <a href="{{ route('prediksi.index') }}" class="nav-link">
        Prediksi Beban
        </a>
        <a href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100 mt-2">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="content-area">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@yield('scripts')
</body>
</html>
