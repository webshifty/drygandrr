@extends('layouts.main')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <h2>Реєстрація</h2>
    <div class="field">
        <input name="name" type="text" value="{{ old('name') }}" placeholder="Ім'я та Призвіще" required autofocus autocomplete="name">
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="field">
        <input name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="field">
        <input name="password" type="password" placeholder="Пароль" required autocomplete="new-password">
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="field">
        <input name="password_confirmation" type="password" placeholder="Повторіть пароль" required autocomplete="new-password">
        @error('password_confirmation')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="action">
        <button class="button" type="submit">Зареєструватись</button>
        <div class="links">
            <span>Вже зареєстровані?</span>
            <a href="{{ route('login') }}">Увійди в кабінет</a>
        </div>
    </div>
</form>
@endsection