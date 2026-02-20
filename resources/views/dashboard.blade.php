@extends('layout.index')
@section('main')

<h2>Dashboard</h2>
<p>Вы вошли как <b>{{ auth()->user()->email }}</b></p>
<p>Роль: <b>{{ auth()->user()->role }}</b></p>

@endsection
