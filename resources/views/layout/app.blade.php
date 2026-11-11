<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>

    <header>
        <h2>Sistem Informasi Surat</h2>
        <hr>
        <nav>
            <ul>
               <li><a href="{{ route('dashboard') }}">Dashboard</a></li> 
               <li><a href="{{ route('surat-masuk.index') }}">Surat Masuk</a></li>
               <li><a href="{{ route('surat-keluar.index') }}">Surat Keluar</a></li>
            </ul>
        </nav>
        <hr>
    </header>

    <main>
    @yield('content')
    </main>

    @auth
    <span>Masuk sebagai: {{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}" style="display: inline">
        @csrf
        <button type="submit">Keluar</button>
    </form>
    @endauth

    <footer>
        <P>Sistem Informasi Surat</P>
    </footer>

</body>
</html>