@extends('layout.index')
@section('title','Подачи')
@section('main')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Мои подачи</h3>
</div>

{{-- Создание подачи --}}
<div class="card mb-4">
  <div class="card-body">
    <h5 class="card-title">Создать подачу</h5>

    <form method="POST" action="{{ route('submissions.store') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">Название</label>
        <input class="form-control" name="title" value="{{ old('title') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Описание</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
      </div>

      <button class="btn btn-primary">Создать</button>
    </form>
  </div>
</div>

{{-- Список подач --}}
<div class="card">
  <div class="card-header">Список подач</div>

  <div class="list-group list-group-flush">
    @forelse($submissions as $s)
      <div class="list-group-item">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="fw-semibold">
              <a href="{{ route('submissions.show', $s) }}">#{{ $s->id }} — {{ $s->title }}</a>
            </div>
            <div class="text-muted small">Статус: {{ $s->status }}</div>
          </div>
          <span class="badge bg-secondary">{{ $s->status }}</span>
        </div>

        {{-- Загрузка файла сразу на этой странице --}}
        @if($s->status === 'draft')
          <form class="mt-3" method="POST" action="{{ route('attachments.upload', $s) }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-2 align-items-center">
              <div class="col-md-8">
                <input class="form-control" type="file" name="file" required>
                <div class="form-text">pdf/zip/png/jpg, до 10MB, максимум 3 файла</div>
              </div>
              <div class="col-md-4 d-grid">
                <button class="btn btn-outline-primary">Прикрепить файл</button>
              </div>
            </div>
          </form>
        @else
          <div class="text-muted small mt-2">
            Файлы можно добавлять только в статусе <b>draft</b>.
          </div>
        @endif

        {{-- Быстрый просмотр файлов --}}
        @if($s->attachments && $s->attachments->count())
          <div class="mt-3">
            <div class="small text-muted mb-1">Файлы:</div>
            <ul class="mb-0">
              @foreach($s->attachments as $a)
                <li>
                  {{ $a->original_name }} ({{ $a->status }})
                  <a href="{{ route('attachments.download', $a) }}">скачать</a>
                </li>
              @endforeach
            </ul>
          </div>
        @endif

      </div>
    @empty
      <div class="list-group-item text-muted">Пока подач нет</div>
    @endforelse
  </div>
</div>

<div class="mt-3">
  {{ $submissions->links() }}
</div>

@endsection
