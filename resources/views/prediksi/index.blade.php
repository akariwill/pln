@extends('layouts.app')

@section('content')
<style>
    /* Penyesuaian style untuk tampilan yang lebih kecil */
    .stat-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        overflow: hidden;
        border-left: 4px solid transparent;
        transition: all 0.2s ease-in-out;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.07);
    }
    .stat-card .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem; /* Padding diperkecil */
    }
    .stat-card .stat-icon {
        font-size: 2rem; /* Ukuran ikon diperkecil */
        opacity: 0.15;
    }
    .stat-card .stat-content h5 {
        font-size: 0.75rem; /* Ukuran font judul diperkecil */
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.1rem;
        text-transform: uppercase;
    }
    .stat-card .stat-content h3 {
        font-size: 1.5rem; /* Ukuran font data diperkecil */
        font-weight: 700;
        color: #212529;
    }
    .stat-card.border-primary { border-left-color: #0d6efd; }
    .stat-card.border-primary .stat-icon { color: #0d6efd; }
    .stat-card.border-dark { border-left-color: #212529; }
    .stat-card.border-dark .stat-icon { color: #212529; }

    .main-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .main-card .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 600;
        font-size: 0.9rem; /* Ukuran font header kartu diperkecil */
        padding: 0.75rem 1rem;
    }
    .main-card .card-body {
        padding: 1rem;
    }
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        color: #6c757d;
        background-color: #f8f9fa;
    }
    .empty-state .icon { font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.5; }
    .empty-state h6 { font-size: 1rem; }
    .empty-state p { font-size: 0.85rem; }
</style>

<div class="mb-3">
    <h4 class="fw-bold">Prediksi Beban Listrik</h4>
    <p class="text-muted small mb-0">Pilih penyulang untuk memulai prediksi.</p>
</div>

@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center shadow-sm p-2 mb-3">
        <i class="fas fa-exclamation-triangle fa-fw me-2"></i>
        <small>{{ session('error') }}</small>
    </div>
@endif

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card main-card h-100">
            <div class="card-header"><i class="fas fa-magic me-2"></i> Formulir Prediksi</div>
            <div class="card-body d-flex flex-column">
                <form id="prediction-form" action="{{ route('prediksi.submit') }}" method="POST" class="d-flex flex-column flex-grow-1">
                    @csrf
                    <div class="mb-3 flex-grow-1">
                        <label for="penyulang" class="form-label fw-bold small">Pilih Penyulang</label>
                        <select name="penyulang" id="penyulang" class="form-select" required>
                            <option value="" disabled {{ !session('penyulang') ? 'selected' : '' }}>-- Pilih salah satu --</option>
                            @foreach($penyulangs as $p)
                                <option value="{{ $p->nama }}" {{ session('penyulang') == $p->nama ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button id="submit-button" type="submit" class="btn btn-primary w-100 mt-auto">
                        <span id="button-text"><i class="fas fa-chart-line me-2"></i> Prediksi</span>
                        <span id="button-spinner" class="d-none"><i class="fas fa-spinner fa-spin me-2"></i> Memprediksi...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div id="area-cetak">
            @if(session('result'))
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Hasil untuk: <span class="text-primary">{{ session('penyulang') }}</span></h5>
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="fas fa-print me-1"></i> Cetak</button>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6"><div class="card stat-card border-primary"><div class="card-body"><div class="stat-content"><h5>Prediksi Siang</h5><h3>{{ number_format(session('result.prediksi_mw_siang'), 2) }} <small class="fs-6 text-muted">MW</small></h3></div><div class="stat-icon"><i class="fas fa-sun"></i></div></div></div></div>
                        <div class="col-md-6"><div class="card stat-card border-dark"><div class="card-body"><div class="stat-content"><h5>Prediksi Malam</h5><h3>{{ number_format(session('result.prediksi_mw_malam'), 2) }} <small class="fs-6 text-muted">MW</small></h3></div><div class="stat-icon"><i class="fas fa-moon"></i></div></div></div></div>
                    </div>

                    <div class="card main-card">
                        <div class="card-header">Grafik Prediksi Beban</div>
                        <div class="card-body">
                            <canvas id="chartPrediksi" height="160"></canvas> </div>
                    </div>

                    @if(session('result.prediksi_mw_siang') < 0 || session('result.prediksi_mw_malam') < 0)
                        <div class="alert alert-warning d-flex align-items-center shadow-sm p-2"><i class="fas fa-exclamation-circle fa-fw me-2"></i><small>⚠️ Nilai prediksi tidak valid. Harap periksa ulang model.</small></div>
                    @endif
                </div>
            @else
                <div class="card main-card h-100">
                    <div class="card-body empty-state">
                        <div class="icon"><i class="fas fa-chart-bar"></i></div>
                        <h6 class="fw-bold">Menunggu Prediksi</h6>
                        <p class="mb-0">Hasil akan ditampilkan di sini.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('prediction-form');
    if(form) {
        form.addEventListener('submit', function() {
            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const buttonSpinner = document.getElementById('button-spinner');

            if (submitButton && buttonText && buttonSpinner) {
                submitButton.disabled = true;
                buttonText.classList.add('d-none');
                buttonSpinner.classList.remove('d-none');
            }
        });
    }

    @if(session('result'))
        const ctx = document.getElementById('chartPrediksi')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Siang', 'Malam'],
                    datasets: [{
                        label: 'Prediksi Beban (MW)',
                        data: [
                            {{ session('result.prediksi_mw_siang', 0) }},
                            {{ session('result.prediksi_mw_malam', 0) }}
                        ],
                        backgroundColor: ['#36A2EB', '#212529'],
                        borderColor: ['#36A2EB', '#212529'],
                        borderWidth: 1,
                        borderRadius: 4,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: tooltipItem => `${tooltipItem.dataset.label}: ${tooltipItem.raw.toFixed(2)} MW`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Beban (MW)' }
                        }
                    }
                }
            });
        }
    @endif
});
</script>
@endsection