@extends('layout.index')
@section('title','Жюри')
@section('main')

@php
  $statusMap = [
    'draft' => 'Черновик',
    'submitted' => 'Отправлено',
    'needs_fix' => 'Нужны правки',
    'accepted' => 'Принято',
    'rejected' => 'Отклонено',
  ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="mb-0">Панель жюри</h3>
    <div class="text-muted small">Здесь можно просматривать все подачи и фильтровать по статусу.</div>
  </div>

  <form class="d-flex gap-2" method="GET">
    <select class="form-select form-select-sm" name="status">
      <option value="">Все статусы</option>

      <option value="draft" @if(($status ?? '') === 'draft') selected @endif>
        {{ $statusMap['draft'] }}
      </option>

      <option value="submitted" @if(($status ?? '') === 'submitted') selected @endif>
        {{ $statusMap['submitted'] }}
      </option>

      <option value="needs_fix" @if(($status ?? '') === 'needs_fix') selected @endif>
        {{ $statusMap['needs_fix'] }}
      </option>

      <option value="accepted" @if(($status ?? '') === 'accepted') selected @endif>
        {{ $statusMap['accepted'] }}
      </option>

      <option value="rejected" @if(($status ?? '') === 'rejected') selected @endif>
        {{ $statusMap['rejected'] }}
      </option>
    </select>

    <button class="btn btn-sm btn-outline-primary">Фильтр</button>
  </form>
</div>

<div class="card">
  <div class="card-header">Подачи</div>

  <ul class="list-group list-group-flush">
    @forelse($submissions as $s)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <div class="fw-semibold">
            <a href="{{ route('jury.submissions.show', $s) }}">
              #{{ $s->id }} — {{ $s->title }}
            </a>
          </div>

          <div class="text-muted small">
            Автор: {{ $s->user->email ?? '—' }}
            • Статус: {{ $statusMap[$s->status] ?? $s->status }}
          </div>
        </div>

        <span class="badge bg-secondary">
          {{ $statusMap[$s->status] ?? $s->status }}
        </span>
      </li>
    @empty
      <li class="list-group-item text-muted">Подач пока нет</li>
    @endforelse
  </ul>
</div>

<div class="mt-3">
  {{ $submissions->links() }}
</div>

@endsection
