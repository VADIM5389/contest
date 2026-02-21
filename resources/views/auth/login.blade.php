@extends('layout.index')
@section('title','Вход')
@section('main')

<div class="row justify-content-center">
  <div class="col-12 col-md-7 col-lg-5">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4 p-md-5">
        <div class="mb-3">
          <h3 class="fw-semibold mb-1">Вход</h3>
          <div class="text-muted small">Введите email и пароль, чтобы войти в систему.</div>
        </div>

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="name@example.com"
              required
              autofocus
            >
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input
              type="password"
              name="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="••••••••"
              required
            >
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember">Запомнить меня</label>
            </div>
          </div>

          <button class="btn btn-primary w-100">Войти</button>

          <div class="text-center mt-3">
            <span class="text-muted">Нет аккаунта?</span>
            <a href="{{ route('register') }}">Регистрация</a>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

@endsection