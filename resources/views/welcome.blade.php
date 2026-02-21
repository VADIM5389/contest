@extends('layout.index')
@section('title','Главная')
@section('main')

<div class="row g-4 align-items-stretch">
  <div class="col-lg-7">
    <div class="card shadow-sm border-0 h-100 hero-card">
      <div class="card-body p-4 p-md-5">
        <span class="badge text-bg-primary mb-3">Платформа конкурса</span>

        <h1 class="display-6 fw-semibold mb-3">
          Подавайте работы удобно, проверяйте быстро, управляйте ролями.
        </h1>

        <p class="text-muted mb-4">
          Здесь участники создают подачи и прикрепляют файлы, жюри выставляет статусы и оставляет комментарии,
          а администратор управляет ролями пользователей.
        </p>

        <div class="d-flex flex-wrap gap-2">
          @auth
            <a class="btn btn-primary" href="{{ route('submissions.index') }}">Перейти к подачам</a>

            @if(auth()->user()->role === 'jury' || auth()->user()->role === 'admin')
              <a class="btn btn-outline-secondary" href="{{ route('jury.index') }}">Панель жюри</a>
            @endif

            @if(auth()->user()->role === 'admin')
              <a class="btn btn-outline-secondary" href="{{ route('admin.index') }}">Админ-панель</a>
            @endif
          @endauth

          @guest
            <a class="btn btn-primary" href="{{ route('register') }}">Начать</a>
            <a class="btn btn-outline-secondary" href="{{ route('login') }}">У меня уже есть аккаунт</a>
          @endguest
        </div>

        <hr class="my-4">

        <div class="row g-3">
          <div class="col-md-4">
            <div class="mini-card p-3 rounded-3 border bg-white">
              <div class="fw-semibold">Участник</div>
              <div class="text-muted small">Создаёт подачу и прикрепляет файлы</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mini-card p-3 rounded-3 border bg-white">
              <div class="fw-semibold">Жюри</div>
              <div class="text-muted small">Проверяет и меняет статусы</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mini-card p-3 rounded-3 border bg-white">
              <div class="fw-semibold">Админ</div>
              <div class="text-muted small">Управляет ролями пользователей</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body p-4 p-md-5">
        <h5 class="fw-semibold mb-3">Что можно сделать на платформе</h5>

        <ul class="list-group list-group-flush">
          <li class="list-group-item px-0 d-flex justify-content-between">
            <span>Создать подачу</span>
            <span class="text-muted">✔</span>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between">
            <span>Прикрепить до 3 файлов</span>
            <span class="text-muted">✔</span>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between">
            <span>Фильтровать подачи (жюри)</span>
            <span class="text-muted">✔</span>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between">
            <span>Комментарии от жюри</span>
            <span class="text-muted">✔</span>
          </li>
          <li class="list-group-item px-0 d-flex justify-content-between">
            <span>Изменение ролей (админ)</span>
            <span class="text-muted">✔</span>
          </li>
        </ul>

        <div class="alert alert-info mt-4 mb-0 border-0">
          <div class="fw-semibold">Подсказка</div>
          <div class="small">
            Для демонстрации: зарегистрируйся, затем назначь роли через админку (или через базу).
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection