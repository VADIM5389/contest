<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Платформа конкурса')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-body-tertiary">

<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">Главная</a>
        </li>

        @auth
          <li class="nav-item">
            <a class="nav-link @if(request()->routeIs('submissions.*')) active @endif" href="{{ route('submissions.index') }}">Мои подачи</a>
          </li>

          @if(auth()->user()->role === 'jury' || auth()->user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('jury.*')) active @endif" href="{{ route('jury.index') }}">Жюри</a>
            </li>
          @endif

          @if(auth()->user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('admin.*')) active @endif" href="{{ route('admin.index') }}">Админ</a>
            </li>
          @endif
        @endauth
      </ul>

      <div class="d-flex align-items-center gap-2">
        @auth
          <span class="text-muted small d-none d-lg-inline">
            {{ auth()->user()->email }}
          </span>

          <span class="badge text-bg-light border d-none d-lg-inline">
            {{ auth()->user()->role }}
          </span>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-secondary btn-sm" type="submit">Выход</button>
          </form>
        @endauth

        @guest
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('login') }}">Вход</a>
          <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Регистрация</a>
        @endguest
      </div>
    </div>
  </div>
</nav>

<main class="container py-4">
    @if(session('ok'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('ok') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('main')
</main>

<footer class="border-top bg-white">
  <div class="container py-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
    <div class="text-muted small">© {{ date('Y') }} Платформа конкурса</div>
    <div class="text-muted small">Laravel</div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>