<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">Uptime Checker</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ route('welcome') }}"
                        class="nav-link {{ Route::currentRouteName() == 'welcome' ? 'active' : '' }}"
                        aria-current="page">Home</a></li>
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Lod in</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                <li class="nav-item"><a href="{{ route('personal.index') }}"
                        class="nav-link {{ Route::currentRouteName() == 'personal.website.index' ? 'active' : '' }}">Personal</a>
                </li>
            </ul>
        </header>
    </div>
    <div>
        @yield('content')
    </div>
</body>

</html>
