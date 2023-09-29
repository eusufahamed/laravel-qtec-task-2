<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">URL Shortener</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        @if (!auth()->check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register_form') }}">Signin</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('login_form') }}">Login</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('url.create') }}">Shortener</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('statistic') }}">Statistics</a>
            </li>

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link" style="border: none; background: none; cursor: pointer;">Logout</button>
                </form>
            </li>
        @endif
      </ul>
    </div>
  </div>
</nav>