@extends('layouts.app')

@section('content')

<div class="flex gap-6">

    <!-- ================= FORM ================= -->
    <div class="w-1/3">
        <div class="bg-white p-6 rounded-xl shadow-sm border">

            <h2 class="text-sm font-semibold mb-5 flex items-center gap-2">
                <i data-lucide="lock" class="w-4 h-4"></i>
                Form Sandi
            </h2>

            <form action="{{ route('admin.kredensial.store') }}" method="POST">
                @csrf

                <!-- NEGARA -->
                <div class="mb-4">
                    <label class="text-xs text-gray-500">Negara</label>

                    <div class="relative mt-1">
                        <i data-lucide="globe" class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"></i>

                        <select name="negara"
                        class="w-full pl-9 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 outline-none">

                         <option value="">-- Pilih Negara --</option>

                        @foreach($countries as $c)
                         <option value="{{ $c }}">{{ $c }}</option>
                         @endforeach

                    </select>
                    </div>

                    @error('negara')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- USERNAME -->
                <div class="mb-4">
                    <label class="text-xs text-gray-500">Username</label>

                    <div class="relative mt-1">
                        <i data-lucide="user" class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"></i>

                        <input type="text" name="username"
                            class="w-full pl-9 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 outline-none">
                    </div>

                    @error('username')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-5">
                    <label class="text-xs text-gray-500">Password</label>

                    <div class="relative mt-1">
                        <i data-lucide="key" class="w-4 h-4 absolute left-3 top-2.5 text-gray-400"></i>

                        <input type="password" id="passwordInput" name="password"
                            class="w-full pl-9 pr-10 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 outline-none">

                        <button type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-2.5 text-gray-400">
                            <i data-lucide="eye"></i>
                        </button>
                    </div>

                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium">
                    Simpan
                </button>

            </form>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="w-2/3">

        <!-- SEARCH + FILTER -->
        <form method="GET" action="{{ route('admin.kredensial.index') }}" class="flex justify-end gap-2 mb-4">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari negara / username..."
                class="px-4 py-2 border rounded-lg text-sm w-64">

            <select name="status"
    onchange="this.form.submit()"
    class="px-3 py-2 border rounded-lg text-sm">

    <option value="all">Semua Status</option>
    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
    <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Disetujui</option>
    <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Ditolak</option>
</select>

            <button class="bg-red-500 text-white px-4 rounded-lg text-sm">Cari</button>
        </form>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm border p-4">

            <h2 class="text-sm font-semibold mb-4">Daftar Kredensial</h2>

            <table class="w-full text-sm">
                <thead class="text-gray-400 text-xs">
                    <tr>
                        <th class="text-left py-2">#</th>
                        <th>Negara</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $i => $d)
                    <tr class="border-t">
                        <td class="py-3">
                            {{ ($data->currentPage()-1)*$data->perPage()+$i+1 }}
                        </td>

                        <td>{{ $d->negara }}</td>

                        <td>
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs">
                                {{ $d->username }}
                            </span>
                        </td>

                        <td>
                            •••••••
                            <button onclick="togglePass(this,'{{ $d->password }}')" class="ml-1 text-gray-400">
                                👁
                            </button>
                        </td>

                        <td>
                            @if($d->status=='approved')
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">Disetujui</span>
                            @elseif($d->status=='pending')
                                <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">Pending</span>
                            @else
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">Ditolak</span>
                            @endif
                        </td>

                        <td>{{ $d->tanggal }}</td>

                        <td class="flex gap-2 justify-center">

                            @if($d->status=='pending')
                            <a href="{{ route('admin.kredensial.approve',$d->id) }}"
                               class="bg-green-500 text-white px-2 rounded text-xs">✔</a>

                            <a href="{{ route('admin.kredensial.reject',$d->id) }}"
                               class="bg-red-500 text-white px-2 rounded text-xs">✖</a>
                            @endif

                            <form action="{{ route('admin.kredensial.destroy',$d->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="bg-gray-300 px-2 rounded text-xs">🗑</button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="mt-4">
                {{ $data->links() }}
            </div>

        </div>
    </div>

</div>

<!-- SCRIPT -->
<script>
function togglePassword(){
    let input = document.getElementById('passwordInput');
    input.type = input.type === 'password' ? 'text' : 'password';
}

function togglePass(btn, pass){
    if(btn.innerText === '👁'){
        btn.parentElement.innerHTML = pass + ' <button onclick="togglePass(this, \''+pass+'\')">🙈</button>';
    }else{
        btn.parentElement.innerHTML = '••••••• <button onclick="togglePass(this, \''+pass+'\')">👁</button>';
    }
}
</script>

@endsection