@extends('layout.index')
@section('title','Подача')
@section('main')

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Подача #{{ $submission->id }}</h3>
  <span class="badge bg-secondary">{{ $submission->status }}</span>
</div>

<div class="card mb-3">
  <div class="card-body">
    <form method="POST" action="{{ route('submissions.update', $submission) }}">
      @csrf
      @method('PUT')

      <div class="mb-2">
        <label class="form-label">Название</label>
        <input class="form-control" name="title" value="{{ old('title',$submission->title) }}" required>
      </div>

      <div class="mb-2">
        <label class="form-label">Описание</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description',$submission->description) }}</textarea>
      </div>

      <button class="btn btn-primary">Сохранить</button>
    </form>

    <form method="POST" action="{{ route('submissions.submit', $submission) }}" class="mt-2">
      @csrf
      <button class="btn btn-success">Отправить (submit)</button>
    </form>

    <hr class="my-4">

    <form method="POST" action="{{ route('attachments.upload', $submission) }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-2">
        <label class="form-label">Загрузить файл (до 10MB, максимум 3)</label>
        <input class="form-control" type="file" name="file" required>
      </div>
      <button class="btn btn-outline-primary">Загрузить</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">Файлы</div>
  <ul class="list-group list-group-flush">
    @forelse($submission->attachments as $a)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <div class="fw-semibold">{{ $a->original_name }}</div>
          <div class="text-muted small">{{ $a->status }}</div>
        </div>
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('attachments.download', $a) }}">Скачать</a>
      </li>
    @empty
      <li class="list-group-item text-muted">Файлов пока нет</li>
    @endforelse
  </ul>
</div>

@endsection
