@extends('layouts.app')

@section('content')
<style>
    /* Custom styles untuk mempercantik dashboard */
    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease-in-out;
        overflow: hidden; /* Penting untuk efek border */
        border-left: 5px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    
    .stat-card .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-card .stat-icon {
        font-size: 2.5rem;
        opacity: 0.2;
    }

    .stat-card .stat-content h5 {
        font-size: 0.9rem;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
    }

    /* Variasi warna border dan ikon */
    .stat-card.border-primary { border-left-color: #0d6efd; }
    .stat-card.border-primary .stat-icon { color: #0d6efd; }

    .stat-card.border-danger { border-left-color: #dc3545; }
    .stat-card.border-danger .stat-icon { color: #dc3545; }

    .stat-card.border-success { border-left-color: #198754; }
    .stat-card.border-success .stat-icon { color: #198754; }

    .stat-card.border-warning { border-left-color: #ffc107; }
    .stat-card.border-warning .stat-icon { color: #ffc107; }
    
    .chart-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .chart-card .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 600;
        color: #343a40;
    }
</style>

<!-- Header Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Dashboard</h3>
    <span class="text-muted">{{ now()->translatedFormat('l, j F Y') }}</span>
</div>

<!-- Kartu Statistik -->
<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-primary h-100">
            <div class="card-body">
                <div class="stat-content">
                    <h5 class="card-title">Beban Hari Ini</h5>
                    <h3>{{ number_format($totalBebanHariIni, 2) }} <small class="fs-6 text-muted">MW</small></h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-bolt-lightning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-danger h-100">
            <div class="card-body">
                <div class="stat-content">
                    <h5 class="card-title">Beban Bulan Ini</h5>
                    <h3>{{ number_format($totalBebanBulanIni, 2) }} <small class="fs-6 text-muted">MW</small></h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-success h-100">
            <div class="card-body">
                <div class="stat-content">
                    <h5 class="card-title">Total Penyulang</h5>
                    <h3>{{ $totalPenyulang }}</h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card border-warning h-100">
            <div class="card-body">
                <div class="stat-content">
                    <h5 class="card-title">Prediksi Besok</h5>
                    <h3>{{ number_format($prediksiBesok, 2) }} <small class="fs-6 text-muted">MW</small></h3>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grafik -->
<div class="row g-4 mt-2">
    <div class="col-lg-7">
        <div class="card chart-card h-100">
            <div class="card-header">Tren Beban Bulanan</div>
            <div class="card-body d-flex align-items-center">
                <canvas id="bebanChart" style="height: 320px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card chart-card h-100">
            <div class="card-header">Riwayat Beban Harian</div>
            <div class="card-body d-flex align-items-center">
                <canvas id="grafikPrediksi" style="height: 320px;"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Fungsi helper untuk parsing JSON dengan aman
    function parseJsonData(dataString) {
        try {
            // Mengganti entitas HTML yang mungkin ada
            const decodedString = dataString.replace(/&quot;/g, '"');
            return JSON.parse(decodedString);
        } catch (e) {
            console.error('Error parsing JSON data:', e, "Data string:", dataString);
            return []; // Mengembalikan array kosong jika ada error
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // --- Grafik Beban Bulanan ---
        const bebanChartElement = document.getElementById('bebanChart');
        if (bebanChartElement) {
            const ctxBeban = bebanChartElement.getContext('2d');
            const grafikBulanData = parseJsonData('{!! addslashes(json_encode($grafikBulan)) !!}');
            const grafikDataBeban = parseJsonData('{!! addslashes(json_encode($grafikData)) !!}');

            const gradient = ctxBeban.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(0, 123, 255, 0.3)');
            gradient.addColorStop(1, 'rgba(0, 123, 255, 0)');

            new Chart(ctxBeban, {
                type: 'line',
                data: {
                    labels: grafikBulanData,
                    datasets: [{
                        label: 'Beban (MW)',
                        data: grafikDataBeban,
                        backgroundColor: gradient,
                        borderColor: '#007bff',
                        borderWidth: 2,
                        pointBackgroundColor: '#007bff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: {
                                color: '#e9ecef',
                                borderDash: [5, 5]
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // --- Grafik Riwayat Beban Harian (Prediksi) ---
        const grafikPrediksiElement = document.getElementById('grafikPrediksi');
        if (grafikPrediksiElement) {
            const ctxPrediksi = grafikPrediksiElement.getContext('2d');
            const labelPrediksiData = parseJsonData('{!! addslashes(json_encode($labelPrediksi)) !!}');
            const dataPrediksiSiangData = parseJsonData('{!! addslashes(json_encode($dataPrediksiSiang)) !!}');
            const dataPrediksiMalamData = parseJsonData('{!! addslashes(json_encode($dataPrediksiMalam)) !!}');

            new Chart(ctxPrediksi, {
                type: 'bar',
                data: {
                    labels: labelPrediksiData,
                    datasets: [{
                        label: 'MW Siang',
                        data: dataPrediksiSiangData,
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderRadius: 4
                    }, {
                        label: 'MW Malam',
                        data: dataPrediksiMalamData,
                        borderColor: '#FF6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endsection