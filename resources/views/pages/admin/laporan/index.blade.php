@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-sm border">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-sm font-semibold">Laporan Akses</h2>

        <a href="{{ route('admin.laporan.pdf', request()->query()) }}"
           class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">
            Export PDF
        </a>
    </div>

    <!-- FILTER -->
    <form method="GET" class="flex gap-2 mb-4 flex-wrap">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari negara / user..."
            class="border px-3 py-2 rounded-lg text-sm">

        <select name="status" class="border px-3 py-2 rounded-lg text-sm">
            <option value="all">Semua</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Disetujui</option>
            <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Ditolak</option>
        </select>

        <button class="bg-red-500 text-white px-4 rounded-lg text-sm">
            Filter
        </button>

    </form>

    <!-- TABLE -->
    <table class="w-full text-sm">
        <thead class="text-gray-400 text-xs">
            <tr>
                <th class="text-left py-2">#</th>
                <th>Negara</th>
                <th>Username</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $i => $d)
            <tr class="border-t">
                <td class="py-3">
                    {{ ($data->currentPage()-1)*$data->perPage()+$i+1 }}
                </td>

                <td>{{ $d->negara }}</td>
                <td>{{ $d->username }}</td>

                <td>
                    @if($d->status=='approved')
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">Disetujui</span>
                    @elseif($d->status=='pending')
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">Pending</span>
                    @else
                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">Ditolak</span>
                    @endif
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-400">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $data->links() }}
    </div>

</div>

@endsection