@extends('layouts.app')

@section('content')
<center>
    <h3>Dashboard</h3>
    <p>Welcome to PLN Prediction</p>
    
</center>
<div class="row g-3">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5>Total Beban Hari Ini</h5>
                <h3>{{ number_format($totalBebanHariIni, 2) }} MW</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5>Total Beban Bulan Ini</h5>
                <h3>{{ number_format($totalBebanBulanIni, 2) }} MW</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-dark bg-warning">
            <div class="card-body">
                <h5>Total Penyulang</h5>
                <h3>{{ $totalPenyulang }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5>Prediksi Beban Besok</h5>
                <h3>{{ number_format($prediksiBesok, 2) }} MW</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">Tren Beban Bulanan</div>
            <div class="card-body">
                <canvas id="bebanChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">Riwayat Beban Harian</div>
            <div class="card-body">
                <canvas id="grafikPrediksi" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Pastikan Chart.js sudah dimuat sebelum kode ini dijalankan.
    // Jika belum, tambahkan script untuk memuat Chart.js di bagian <head> atau sebelum ini.

    // Fungsi helper untuk parsing JSON dengan aman
    function parseJsonData(dataString) {
        try {
            return JSON.parse(dataString);
        } catch (e) {
            console.error('Error parsing JSON data:', e);
            return []; // Mengembalikan array kosong jika ada error
        }
    }

    // --- Grafik Beban Bulanan ---
    const bebanChartElement = document.getElementById('bebanChart');
    if (bebanChartElement) {
        const ctxBeban = bebanChartElement.getContext('2d');
        const grafikBulanData = parseJsonData('{!! json_encode($grafikBulan) !!}');
        const grafikDataBeban = parseJsonData('{!! json_encode($grafikData) !!}');

        new Chart(ctxBeban, {
            type: 'line',
            data: {
                labels: grafikBulanData,
                datasets: [{
                    label: 'Beban (MW)',
                    data: grafikDataBeban,
                    backgroundColor: 'rgba(0, 123, 255, 0.4)',
                    borderColor: '#007bff',
                    fill: true,
                    tension: 0.3 // Menambahkan sedikit kelengkungan pada garis
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Penting jika Anda mengelola ukuran kanvas dengan CSS
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Beban (MW)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                }
            }
        });
    } else {
        console.warn("Elemen dengan ID 'bebanChart' tidak ditemukan.");
    }


    // --- Grafik Riwayat Beban Harian (Prediksi) ---
    const grafikPrediksiElement = document.getElementById('grafikPrediksi');
    if (grafikPrediksiElement) {
        const ctxPrediksi = grafikPrediksiElement.getContext('2d');
        const labelPrediksiData = parseJsonData('{!! json_encode($labelPrediksi) !!}');
        const dataPrediksiSiangData = parseJsonData('{!! json_encode($dataPrediksiSiang) !!}');
        const dataPrediksiMalamData = parseJsonData('{!! json_encode($dataPrediksiMalam) !!}');

        new Chart(ctxPrediksi, {
            type: 'line',
            data: {
                labels: labelPrediksiData,
                datasets: [{
                    label: 'MW Siang',
                    data: dataPrediksiSiangData,
                    borderColor: '#36A2EB',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Tambahkan background agar lebih terlihat
                    fill: false,
                    tension: 0.3
                }, {
                    label: 'MW Malam',
                    data: dataPrediksiMalamData,
                    borderColor: '#FF6384',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Tambahkan background agar lebih terlihat
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'MW'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal' // Atau sesuaikan dengan labelPrediksi Anda
                        }
                    }
                }
            }
        });
    } else {
        console.warn("Elemen dengan ID 'grafikPrediksi' tidak ditemukan.");
    }
</script>
@endsection
