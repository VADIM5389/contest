@extends('layout.index')
@section('main')

<h2>Вход</h2>

@if($errors->any())
    <div style="padding:10px;border:1px solid #f99;background:#ffeaea;margin-bottom:12px;">
        <ul style="margin:0;">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
        <label>Email</label><br>
        <input name="email" type="email" value="{{ old('email') }}" required>
    </div>

    <div style="margin-top:10px;">
        <label>Пароль</label><br>
        <input name="password" type="password" required>
    </div>

    <div style="margin-top:10px;">
        <label>
            <input type="checkbox" name="remember" value="1">
            Запомнить меня
        </label>
    </div>

    <button style="margin-top:12px;" type="submit">Войти</button>
</form>

<p style="margin-top:12px;">
    Нет аккаунта? <a href="{{ route('register') }}">Регистрация</a>
</p>

@endsection
