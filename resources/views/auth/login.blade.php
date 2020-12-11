@extends('layouts.main')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <h2>Вхід в Кабінет</h2>
    <div class="field">
        <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
        @if ($errors->any())
            <div class="text-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="field">
        <input type="password" name="password" required autocomplete="current-password" placeholder="Пароль" >
        <a href="{{ route('password.request') }}">Забув пароль?</a>
    </div>
    <div class="action">
        <button class="button" type="submit">Вхід в кабінет</button>
        <div class="links">
            <span>Не маєш свого кабінету?</span>
            <a href="{{ route('register') }}">Зареєструйся</a>
        </div>
    </div>
</form>
@endsection