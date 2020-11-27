<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ДРУГ</title>
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
    <form action="{{ route('login') }}">
        <div class="action">
            <button class="button" type="submit">Вхід в Кабінет</button>
            <div class="links">
                <span>Не маєш свого Кабінету?</span>
                <a href="{{ route('register') }}">Зареєструйся</a>
            </div>
        </div>
    </form>
</main>
</body>
</html>
