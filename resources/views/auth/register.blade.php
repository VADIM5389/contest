@extends('layout.index')
@section('title','Регистрация')
@section('main')

<div class="row justify-content-center">
  <div class="col-12 col-md-8 col-lg-6">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4 p-md-5">
        <div class="mb-3">
          <h3 class="fw-semibold mb-1">Регистрация</h3>
          <div class="text-muted small">Создайте аккаунт участника. Роли жюри/админа выдаёт администратор.</div>
        </div>

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Имя</label>
            <input
              type="text"
              name="name"
              value="{{ old('name') }}"
              class="form-control @error('name') is-invalid @enderror"
              placeholder="Ваше имя"
              required
              autofocus
            >
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="name@example.com"
              required
            >
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Пароль</label>
              <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Минимум 6 символов"
                required
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Повтор пароля</label>
              <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Повторите пароль"
                required
              >
            </div>
          </div>

          <button class="btn btn-primary w-100 mt-4">Создать аккаунт</button>

          <div class="text-center mt-3">
            <span class="text-muted">Уже есть аккаунт?</span>
            <a href="{{ route('login') }}">Войти</a>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>

@endsection