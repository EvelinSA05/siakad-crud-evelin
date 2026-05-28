@extends('layouts.app')
@section('title', 'Rekap Mahasiswa')
@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Rekap Mahasiswa</h1>
        </div>
    </div>

    {{-- SUMMARY CARD --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded">
            <p class="text-sm">Total Mahasiswa</p>
            <p class="text-xl font-bold">
                {{ $dataMahasiswaProdi->sum('total_mahasiswa') }}
            </p>
        </div>
    </div>

    {{-- CHART 1: Mahasiswa per Prodi --}}
    <div class="mb-8">
        <h2 class="text-sm font-semibold mb-2">Jumlah Mahasiswa tiap Program Studi</h2>
        <canvas id="chartProdi"></canvas>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- CHART 2: Mahasiswa per Angkatan --}}
        <div class="bg-gray-50 p-4 rounded-lg h-64">
            <h2 class="text-sm font-semibold mb-2">Mahasiswa per Angkatan</h2>
            <canvas id="chartAngkatan"></canvas>
        </div>

        {{-- CHART 3: Distribusi Gender --}}
        <div class="bg-gray-50 p-4 rounded-lg h-64">
            <h2 class="text-sm font-semibold mb-2">Distribusi Gender</h2>
            <canvas id="chartGender"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- CHART 4: Rata-rata IPK per Prodi --}}
        <div class="bg-gray-50 p-4 rounded-lg h-64">
            <h2 class="text-sm font-semibold mb-2">Rata-Rata IPK tiap Program Studi</h2>
            <canvas id="chartAvgIPK"></canvas>
        </div>

        {{-- CHART 5: Perbandingan Jumlah Mahasiswa berdasarkan Status --}}
        <div class="bg-gray-50 p-4 rounded-lg h-64 flex flex-col items-center">
            <h2 class="text-sm font-semibold mb-2">Perbandingan Jumlah Mahasiswa berdasarkan Status</h2>
            <canvas id="chartStatus"></canvas>
        </div>
    </div>
</div>

{{-- Hidden data containers for JS --}}
<div id="dataProdi" data-value="{{ $dataMahasiswaProdi->toJson() }}" class="hidden"></div>
<div id="dataAngkatan" data-value="{{ $dataMahasiswaAngkatan->toJson() }}" class="hidden"></div>
<div id="dataGender" data-value="{{ $dataMahasiswaPerGender->toJson() }}" class="hidden"></div>
<div id="dataAvgIPK" data-value="{{ $dataAvgIPKPerProdi->toJson() }}" class="hidden"></div>
<div id="dataStatus" data-value="{{ $dataMahasiswaPerStatus->toJson() }}" class="hidden"></div>
@endsection

@push('scripts')
<script>
    // =====================
    // DATA (read from hidden elements)
    // =====================
    const dataProdi    = JSON.parse(document.getElementById('dataProdi').dataset.value);
    const dataAngkatan = JSON.parse(document.getElementById('dataAngkatan').dataset.value);
    const dataGender   = JSON.parse(document.getElementById('dataGender').dataset.value);
    const dataAvgIPK   = JSON.parse(document.getElementById('dataAvgIPK').dataset.value);
    const dataStatus   = JSON.parse(document.getElementById('dataStatus').dataset.value);

    // =====================
    // CHART 1 — Mahasiswa per Prodi (Bar)
    // =====================
    const colorsProdi = [
        '#EF4444', // merah
        '#22C55E', // hijau
        '#3B82F6', // biru
        '#F59E0B', // kuning
        '#8B5CF6', // ungu
        '#EC4899', // pink
        '#14B8A6', // teal
        '#F97316', // oranye
    ];
    new Chart(document.getElementById('chartProdi'), {
        type: 'bar',
        data: {
            labels: dataProdi.map(i => i.prodi),
            datasets: [{
                label: 'Mahasiswa per Prodi',
                data: dataProdi.map(i => i.total_mahasiswa),
                backgroundColor: dataProdi.map((_, idx) => colorsProdi[idx % colorsProdi.length]),
                borderColor: dataProdi.map((_, idx) => colorsProdi[idx % colorsProdi.length]),
                borderWidth: 1
            }]
        },
        options: {
            plugins: { legend: { display: false } }
        }
    });

    // =====================
    // CHART 2 — Mahasiswa per Angkatan (Line)
    // =====================
    new Chart(document.getElementById('chartAngkatan'), {
        type: 'line',
        data: {
            labels: dataAngkatan.map(i => i.angkatan),
            datasets: [{
                label: 'Mahasiswa per Angkatan',
                data: dataAngkatan.map(i => i.total),
                tension: 0.3
            }]
        },
        options: {
            plugins: { legend: { display: false } }
        }
    });

    // =====================
    // CHART 3 — Distribusi Gender (Bar)
    // =====================
    new Chart(document.getElementById('chartGender'), {
        type: 'bar',
        data: {
            labels: dataGender.map(i => i.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'),
            datasets: [{
                data: dataGender.map(i => i.jumlah_mahasiswa)
            }]
        },
        options: {
            plugins: { legend: { display: false } }
        }
    });

    // =====================
    // CHART 4 — Rata-rata IPK per Prodi (Bar)
    // =====================
    new Chart(document.getElementById('chartAvgIPK'), {
        type: 'bar',
        data: {
            labels: dataAvgIPK.map(i => i.prodi),
            datasets: [{
                label: 'Rata-rata IPK',
                data: dataAvgIPK.map(i => parseFloat(i.avg_ipk).toFixed(2))
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 4 }
            }
        }
    });

    // =====================
    // CHART 5 — Perbandingan Jumlah Mahasiswa berdasarkan Status (Doughnut)
    // =====================
    const colorsStatus = ['#22C55E', '#F59E0B', '#3B82F6', '#EF4444', '#8B5CF6'];
    new Chart(document.getElementById('chartStatus'), {
        type: 'pie',
        data: {
            labels: dataStatus.map(i => i.status.charAt(0).toUpperCase() + i.status.slice(1)),
            datasets: [{
                data: dataStatus.map(i => i.jumlah),
                backgroundColor: dataStatus.map((_, idx) => colorsStatus[idx % colorsStatus.length]),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });
</script>
@endpush
