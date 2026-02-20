@extends('layout.index')

@section('title','Главная')

@section('main')

<h1>Сбор работ на конкурс</h1>

<p>
    Здесь участники могут загружать свои работы,
    отслеживать статусы и получать комментарии от жюри.
</p>

@auth
    <a href="{{ route('submissions.index') }}">
        Перейти к подачам
    </a>
@endauth

@guest
    <p>Войдите или зарегистрируйтесь для подачи работы.</p>
@endguest

@endsection
