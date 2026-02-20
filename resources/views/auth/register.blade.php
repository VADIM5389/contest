@extends('layout.index')
@section('main')

<h2>Регистрация</h2>

@if($errors->any())
    <div style="padding:10px;border:1px solid #f99;background:#ffeaea;margin-bottom:12px;">
        <ul style="margin:0;">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label>Имя</label><br>
        <input name="name" value="{{ old('name') }}" required>
    </div>

    <div style="margin-top:10px;">
        <label>Email</label><br>
        <input name="email" type="email" value="{{ old('email') }}" required>
    </div>

    <div style="margin-top:10px;">
        <label>Пароль</label><br>
        <input name="password" type="password" required>
    </div>

    <div style="margin-top:10px;">
        <label>Повтор пароля</label><br>
        <input name="password_confirmation" type="password" required>
    </div>

    <button style="margin-top:12px;" type="submit">Зарегистрироваться</button>
</form>

<p style="margin-top:12px;">
    Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
</p>

@endsection
