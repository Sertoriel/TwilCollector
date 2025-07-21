<!-- resources/views/components/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('messages.index') }}">
            <i class="bi bi-chat-dots me-2"></i>Twilio Message Lookup
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('messages.index') ? 'active' : '' }}"
                        href="{{ route('messages.index') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}"
                        href="{{ route('history') }}">
                        <i class="bi bi-clock-history me-1"></i> Histórico
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="bi bi-info-circle me-1"></i> Sobre
                    </a>
                </li>
            </ul>

            <div class="d-flex">
                @auth
                    <button class="btn btn-outline-light me-2">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">
                            <i class="bi bi-box-arrow-right me-1"></i> Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light">
                        <i class="bi bi-person-plus me-1"></i> Registrar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
