@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="mb-6">
    <h1 class="text-xl font-semibold">Dashboard Administrator</h1>
    <p class="text-sm text-gray-500">Monitoring sistem kredensial</p>
</div>

<!-- CARDS -->
<div class="grid grid-cols-4 gap-4 mb-6 text-sm">

    <div class="bg-white p-4 rounded-xl border">
        <p class="text-gray-400 text-xs">Total</p>
        <h2 class="text-xl font-semibold">{{ $total }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl border">
        <p class="text-gray-400 text-xs">Disetujui</p>
        <h2 class="text-xl text-green-600">{{ $approved }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl border">
        <p class="text-gray-400 text-xs">Pending</p>
        <h2 class="text-xl text-yellow-500">{{ $pending }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl border">
        <p class="text-gray-400 text-xs">Ditolak</p>
        <h2 class="text-xl text-red-500">{{ $rejected }}</h2>
    </div>

</div>

<!-- CHART -->
<div class="grid grid-cols-3 gap-4 mb-6">

    <div class="col-span-2 bg-white p-4 rounded-xl border">
        <canvas id="barChart"></canvas>
    </div>

    <div class="bg-white p-4 rounded-xl border">
        <canvas id="donutChart"></canvas>
    </div>

</div>

<!-- LOG -->
<div class="bg-white p-5 rounded-xl border">

    <div class="flex justify-between mb-4">
        <h2 class="text-sm font-semibold">Log Aktivitas</h2>
        <a href="/admin/laporan" class="text-red-500 text-xs">Lihat semua →</a>
    </div>

    <table class="w-full text-sm">
        <thead class="text-gray-400 text-xs">
            <tr>
                <th>Pengguna</th>
                <th>Role</th>
                <th>Tindakan</th>
                <th>Target</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($logs as $log)
            <tr class="border-t">
                <td>{{ $log['user'] }}</td>
                <td>{{ $log['role'] }}</td>
                <td>{{ $log['aksi'] }}</td>
                <td>{{ $log['target'] }}</td>
                <td>{{ $log['waktu'] }}</td>
                <td>
                    @if($log['status']=='success')
                        <span class="text-green-600">✔ Berhasil</span>
                    @else
                        <span class="text-yellow-500">⚠ Warning</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<!-- CHART SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Submit',
                    data: @json($submit),
                    backgroundColor: '#93C5FD'
                },
                {
                    label: 'Disetujui',
                    data: @json($setujui),
                    backgroundColor: '#34D399'
                },
                {
                    label: 'Ditolak',
                    data: @json($tolak),
                    backgroundColor: '#F87171'
                }
            ]
        }
    });

    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Approved','Pending','Rejected'],
            datasets: [{
                data: [{{ $approved }}, {{ $pending }}, {{ $rejected }}],
                backgroundColor: ['#34D399','#FBBF24','#F87171']
            }]
        }
    });

});
</script>

@endsection