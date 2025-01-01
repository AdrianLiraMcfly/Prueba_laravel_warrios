
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><img src="{{ asset('/img/logo-header.png') }}" alt="Logo" style="height: auto; width:250px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->routeIs('grupos.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('grupos.index') }}">Grupos <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('estudiantes.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('estudiantes.index') }}">Estudiantes</a>
                    </li>
                </ul>
            </div>     
        </nav>
    </header>