@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Hasil Prediksi Beban Listrik Besok</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('result'))
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Hasil Prediksi Beban Listrik</h5>
                <p class="card-text"><strong>Penyulang:</strong> {{ session('penyulang') }}</p>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Prediksi Beban (MW)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Siang</td>
                            <td>{{ number_format(session('result')['prediksi_mw_siang'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>Malam</td>
                            <td>{{ number_format(session('result')['prediksi_mw_malam'], 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <canvas id="chartPrediksi" height="100"></canvas>
            </div>
        </div>

        @if(session('result')['prediksi_mw_siang'] < 0 || session('result')['prediksi_mw_malam'] < 0)
            <div class="alert alert-warning">
                ⚠️ Nilai prediksi tampaknya tidak valid (kurang dari 0 MW). Harap periksa ulang model.
            </div>
        @endif
    @endif

    <form action="{{ route('prediksi.submit') }}" method="POST" class="card p-4 shadow-sm mt-3">
        @csrf
        <div class="mb-3">
            <label for="penyulang">Pilih Penyulang</label>
            <select name="penyulang" class="form-control" required>
                @foreach($penyulangs as $p)
                    <option value="{{ $p->nama }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">Prediksi Beban Besok</button>
    </form>
</div>
@endsection

@section('scripts')
@if(session('result'))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('chartPrediksi').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Siang', 'Malam'],
                datasets: [{
                    label: 'Prediksi Beban (MW)',
                    data: [
                        {{ session('result')['prediksi_mw_siang'] }},
                        {{ session('result')['prediksi_mw_malam'] }}
                    ],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.raw.toFixed(2) + ' MW'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Beban (MW)'
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endsection
