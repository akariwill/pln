<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard PLN Prediction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #111827;
            --sidebar-link-color: #adb5bd;
            --sidebar-link-hover-bg: #374151;
            --sidebar-link-active-bg: #007bff;
            --sidebar-link-active-color: #ffffff;
            --main-bg-color: #f4f7f6;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--main-bg-color);
            overflow-x: hidden;
        }
        
        /* === SIDEBAR === */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh; /* Tinggi penuh */
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            padding: 1rem;
            display: flex;
            flex-direction: column; /* Membuat layout flex vertikal */
            transition: margin-left 0.3s ease-in-out;
            z-index: 1030;
        }

        .sidebar-header {
            padding: 0.5rem 0.75rem;
            margin-bottom: 1.5rem;
            text-align: center;
            flex-shrink: 0; /* Mencegah header menyusut */
        }
        .sidebar-header .app-icon { color: #ffc107; font-size: 1.5rem; }
        .sidebar-header .app-title { font-size: 1.25rem; font-weight: 600; color: #ffffff; }

        .sidebar-nav {
            flex-grow: 1; /* Membuat area navigasi mengisi ruang yang tersisa */
            overflow-y: auto; /* HANYA area ini yang akan scroll jika menu panjang */
        }
        
        .sidebar-footer {
            padding-top: 1rem;
            border-top: 1px solid #374151;
            flex-shrink: 0; /* Mencegah footer menyusut */
        }

        .sidebar a {
            color: var(--sidebar-link-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 12px 15px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        
        .sidebar a .nav-icon {
            width: 20px;
            text-align: center;
            color: #9ca3af;
            transition: color 0.2s ease-in-out;
        }
        
        .sidebar a:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: white;
        }
        .sidebar a:hover .nav-icon { color: white; }

        .sidebar a.active {
            background-color: var(--sidebar-link-active-bg);
            color: var(--sidebar-link-active-color);
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
        }
        .sidebar a.active .nav-icon { color: var(--sidebar-link-active-color); }
        
        .sidebar .menu-header {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #6c757d;
            font-weight: 600;
            margin: 1.5rem 0 0.75rem 0.75rem;
        }

        /* === KONTEN UTAMA === */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease-in-out;
            padding: 0;
            width: calc(100% - var(--sidebar-width));
        }

        .top-navbar {
            padding: 0.75rem 2rem;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* Tambahan untuk Navbar Sticky */
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        
        .content-wrapper {
            padding: 2rem;
        }

        /* === RESPONSIVE === */
        .sidebar-toggler { display: none; border: none; background: none; font-size: 1.5rem; color: #343a40; }

        @media (max-width: 992px) {
            .sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            .main-content { margin-left: 0; width: 100%; }
            body.sidebar-toggled .sidebar { margin-left: 0; }
            .sidebar-toggler { display: block; }
        }
    </style>
</head>
<body>

<div class="sidebar"> 
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-white text-decoration-none">
            <svg class="w-10 h-auto app-icon me-2 align-self-center" viewBox="0 0 80 85" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M55 15 L35 50 L60 50 L40 85 L80 40 L55 40 L75 15 Z" fill="currentColor"/>
            </svg>
            <span class="app-title">PLN Prediction</span>
        </a>
    </div>

    <div class="sidebar-nav">
        <!-- <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home fa-fw nav-icon"></i>
            <span>Dashboard</span>
        </a> -->
        
        <!-- <div class="menu-header">Manajemen Data</div> -->
        <a href="{{ route('gardu-induk.index') }}" class="{{ request()->routeIs('gardu-induk.*') ? 'active' : '' }}">
            <i class="fas fa-network-wired fa-fw nav-icon"></i>
            <span>Gardu Induk</span>
        </a>
        <a href="{{ route('trafo-daya.index') }}" class="{{ request()->routeIs('trafo-daya.*') ? 'active' : '' }}">
            <i class="fas fa-plug fa-fw nav-icon"></i>
            <span>Trafo Daya</span>
        </a>
        <a href="{{ route('penyulang.index') }}" class="{{ request()->routeIs('penyulang.*') ? 'active' : '' }}">
            <i class="fas fa-broadcast-tower fa-fw nav-icon"></i>
            <span>Penyulang</span>
        </a>
        <a href="{{ route('data-penyulang.index') }}" class="{{ request()->routeIs('data-penyulang.*') ? 'active' : '' }}">
            <i class="fas fa-database fa-fw nav-icon"></i>
            <span>Data Penyulang</span>
        </a>
        
        <div class="menu-header">Analisis</div>
        <a href="{{ route('prediksi.index') }}" class="{{ request()->routeIs('prediksi.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line fa-fw nav-icon"></i>
            <span>Prediksi Beban</span>
        </a>
    </div>
    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="fas fa-user-edit fa-fw nav-icon"></i>
            <span>Profil Saya</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none w-100 text-start p-0">
                <a class="w-100 text-danger" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt fa-fw nav-icon"></i>
                    <span>Logout</span>
                </a>
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <nav class="top-navbar">
        <button class="sidebar-toggler" id="sidebar-toggler">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="ms-auto">
            <span class="navbar-text">
                Selamat Datang {{ Auth::user()->name }}
            </span>
        </div>
    </nav>

    <main class="content-wrapper">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggler = document.getElementById('sidebar-toggler');
        if (sidebarToggler) {
            sidebarToggler.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-toggled');
            });
        }
    });
</script>
@yield('scripts')

</body>
</html>