@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('guru-content')

<main class="guru-content">

    <h1>Dashboard Guru</h1>

    <div class="chart-grid">

        <div class="card">
            <h3>Durasi Belajar vs Nilai</h3>
            <canvas id="chartDurasi"></canvas>
        </div>

        <div class="card">
            <h3>Progress vs Nilai</h3>
            <canvas id="chartProgress"></canvas>
        </div>

    </div>

</main>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const durasiData = @json($durasiVsNilai);
const progressData = @json($progressVsNilai);

// ================= DURASI VS NILAI =================
new Chart(document.getElementById('chartDurasi'), {
    type: 'scatter',
    data: {
        datasets: [{
            label: 'Durasi vs Nilai',
            data: durasiData.map(d => ({
                x: d.durasi,
                y: d.nilai
            })),
        }]
    },
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const d = durasiData[context.dataIndex];
                        return `${d.nama} | ${d.durasi} menit - ${d.nilai}`;
                    }
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Durasi (menit)'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Nilai'
                },
                min: 0,
                max: 100
            }
        }
    }
});

// ================= PROGRESS VS NILAI =================
new Chart(document.getElementById('chartProgress'), {
    type: 'scatter',
    data: {
        datasets: [{
            label: 'Progress vs Nilai',
            data: progressData.map(d => ({
                x: d.progress,
                y: d.nilai
            })),
        }]
    },
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const d = progressData[context.dataIndex];
                        return `${d.nama} | ${d.progress}% - ${d.nilai}`;
                    }
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Progress (%)'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Nilai'
                },
                min: 0,
                max: 100
            }
        }
    }
});
</script>

<style>
.chart-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

canvas {
    max-height: 300px;
}
</style>

@endsection