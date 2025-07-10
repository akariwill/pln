<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('gardu-induk.index') }}">Gardu Induk</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('trafo-daya.index') }}">Trafo Daya</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('penyulang.index') }}">Penyulang</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('data-penyulang.index') }}">Data Penyulang</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-light">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
