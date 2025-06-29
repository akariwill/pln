@extends('layouts.app')

@section('content')
<h3>Dashboard</h3>
<p>Selamat datang di Dashboard PLN!</p>

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
    // Grafik Beban Bulanan
    const ctx = document.getElementById('bebanChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($grafikBulan) !!},
            datasets: [{
                label: 'Beban (MW)',
                data: {!! json_encode($grafikData) !!},
                backgroundColor: 'rgba(0, 123, 255, 0.4)',
                borderColor: '#007bff',
                fill: true
            }]
        }
    });

    // Grafik Riwayat Beban Harian (Prediksi)
    const predCtx = document.getElementById('grafikPrediksi').getContext('2d');
    new Chart(predCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelPrediksi) !!},
            datasets: [
                {
                    label: 'MW Siang',
                    data: {!! json_encode($dataPrediksiSiang) !!},
                    borderColor: '#36A2EB',
                    fill: false
                },
                {
                    label: 'MW Malam',
                    data: {!! json_encode($dataPrediksiMalam) !!},
                    borderColor: '#FF6384',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'MW'
                    }
                }
            }
        }
    });
</script>
@endsection
