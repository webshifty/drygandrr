<!--<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="login-page">
<header>
    <div class="header-content">
        <a href="/" class="logo"><img src="{{ asset('img/logo.svg') }}" alt=""></a>
        <nav>
            <ul>
                <li><a href="#">Про систему Друг</a></li>
                <li><a href="#">Карта посольств та консулів</a></li>
                <li><a href="#">Візовий калькулятор</a></li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <form action="">
        <h2>Вхід в Кабінет</h2>
        <div class="field">
            <input name="email" type="email" placeholder="Email">
        </div>
        <div class="field">
            <input name="password" type="password" placeholder="Пароль" >
            <a href="#">Забув пароль?</a>
        </div>
        <div class="action">
            <button class="button" type="submit">Зареєструватись</button>
            <div class="links">
                <span>Не маєш свого Кабінету?</span>
                <a href="registration.html">Зареєструйся</a>
            </div>
        </div>
    </form>
</main>
</body>
</html>
