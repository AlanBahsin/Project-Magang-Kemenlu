@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Dashboard User</h1>

<div class="grid grid-cols-4 gap-4">

    <div class="bg-white p-4 rounded shadow">
        <p>Total Kredensial</p>
        <h2 class="text-xl font-bold">15</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Disetujui</p>
        <h2 class="text-xl font-bold">8</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Pending</p>
        <h2 class="text-xl font-bold">4</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Alert</p>
        <h2 class="text-xl font-bold">2</h2>
    </div>

</div>

@endsection