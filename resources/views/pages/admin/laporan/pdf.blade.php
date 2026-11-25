<h2>Laporan Akses</h2>

<table border="1" width="100%" cellpadding="5">
    <thead>
        <tr>
            <th>#</th>
            <th>Negara</th>
            <th>Username</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->negara }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->status }}</td>
            <td>{{ $d->tanggal }}</td>
        </tr>
        @endforeach
    </tbody>
</table>