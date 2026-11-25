<h1>Dashboard Verifikator</h1>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" style="background:red;color:white;padding:10px;border-radius:6px;">
        Logout
    </button>
</form>