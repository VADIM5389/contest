@extends('layout.index')
@section('title','Админка')
@section('main')

<h3 class="mb-3">Админ-панель</h3>

<div class="card">
  <div class="card-header">Пользователи</div>
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Имя</th>
          <th>Роль</th>
          <th>Сменить роль</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
          <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->name }}</td>
            <td><span class="badge bg-secondary">{{ $u->role }}</span></td>
            <td>
              <form method="POST" action="{{ route('admin.users.role', $u) }}" class="d-flex gap-2">
                @csrf
                <select class="form-select form-select-sm" name="role">
                  @foreach(['participant','jury','admin'] as $r)
                    <option value="{{ $r }}" @if($u->role===$r) selected @endif>{{ $r }}</option>
                  @endforeach
                </select>
                <button class="btn btn-sm btn-primary">OK</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection
