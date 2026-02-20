@extends('layout.index')
@section('title','Подача (жюри)')
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
  <h3 class="mb-0">
    #{{ $submission->id }} — {{ $submission->title }}
  </h3>

  <span class="badge bg-secondary">
    {{ $statusMap[$submission->status] ?? $submission->status }}
  </span>
</div>

<div class="card mb-3">
  <div class="card-body">

    <div class="text-muted small mb-2">
      Автор: {{ $submission->user->email ?? '—' }}
    </div>

    <p>{{ $submission->description }}</p>

    <hr>

    {{-- Смена статуса --}}
    <form method="POST"
          action="{{ route('jury.submissions.status', $submission) }}"
          class="d-flex gap-2 align-items-center">
      @csrf

      <select class="form-select" name="status">
        <option value="draft" @if($submission->status === 'draft') selected @endif>
          {{ $statusMap['draft'] }}
        </option>

        <option value="submitted" @if($submission->status === 'submitted') selected @endif>
          {{ $statusMap['submitted'] }}
        </option>

        <option value="needs_fix" @if($submission->status === 'needs_fix') selected @endif>
          {{ $statusMap['needs_fix'] }}
        </option>

        <option value="accepted" @if($submission->status === 'accepted') selected @endif>
          {{ $statusMap['accepted'] }}
        </option>

        <option value="rejected" @if($submission->status === 'rejected') selected @endif>
          {{ $statusMap['rejected'] }}
        </option>
      </select>

      <button class="btn btn-primary">
        Сохранить статус
      </button>
    </form>

  </div>
</div>

{{-- Файлы --}}
<div class="card mb-3">
  <div class="card-header">Файлы</div>

  <ul class="list-group list-group-flush">
    @forelse($submission->attachments as $a)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <div class="fw-semibold">{{ $a->original_name }}</div>
          <div class="text-muted small">
            Статус: {{ $a->status }}
          </div>
        </div>

        <a class="btn btn-sm btn-outline-secondary"
           href="{{ route('attachments.download', $a) }}">
          Скачать
        </a>
      </li>
    @empty
      <li class="list-group-item text-muted">
        Файлов нет
      </li>
    @endforelse
  </ul>
</div>

{{-- Комментарии --}}
<div class="card">
  <div class="card-header">Комментарии</div>

  <div class="card-body">

    <form method="POST"
          action="{{ route('jury.submissions.comment', $submission) }}">
      @csrf

      <textarea class="form-control"
                name="body"
                rows="3"
                placeholder="Комментарий..."
                required></textarea>

      <button class="btn btn-success mt-2">
        Добавить комментарий
      </button>
    </form>

    <hr>

    @forelse($submission->comments as $c)
      <div class="mb-3">
        <div class="small text-muted">
          {{ $c->user->email ?? '—' }} • {{ $c->created_at }}
        </div>
        <div>{{ $c->body }}</div>
      </div>
    @empty
      <div class="text-muted">
        Комментариев пока нет
      </div>
    @endforelse

  </div>
</div>

@endsection
