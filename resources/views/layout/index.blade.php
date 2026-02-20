<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Конкурс')</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Твой файл стилей --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">Конкурс</a>

    <div class="collapse navbar-collapse show">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">Главная</a>
        </li>

        @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('submissions.index') }}">Подачи</a>
          </li>

          @if(auth()->user()->role === 'jury' || auth()->user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('jury.index') }}">Жюри</a>
            </li>
          @endif

          @if(auth()->user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.index') }}">Админ</a>
            </li>
          @endif
        @endauth
      </ul>

      <div class="d-flex align-items-center gap-2">
        @auth
          <span class="text-white-50 small me-2">
            Роль: <b class="text-white">{{ auth()->user()->role }}</b>
          </span>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-light btn-sm" type="submit">Выход</button>
          </form>
        @endauth

        @guest
          <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Вход</a>
          <a class="btn btn-warning btn-sm" href="{{ route('register') }}">Регистрация</a>
        @endguest
      </div>
    </div>
  </div>
</nav>

<main class="container py-4" style="min-height:70vh;">
    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('main')
</main>

<footer class="border-top py-3 bg-white">
  <div class="container text-muted small">
    © {{ date('Y') }} Платформа конкурса
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
