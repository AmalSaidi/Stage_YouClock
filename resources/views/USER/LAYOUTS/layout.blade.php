<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <img id="logo-YC" src="/images/youclockLogo.png" alt="YouClock">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#">Statistiques</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Fiche horaires</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">Demande de congé</a>
              </li>
          </ul>
          <div style="margin-left: 55%;">
          <div class="dropdown">
  <button class="dropbtn">{{ Auth::user()->name }}</button>
  <div class="dropdown-content">
  <form method="POST" action="{{ route('logout') }}">
@csrf
<x-responsive-nav-link :href="route('logout')"
              onclick="event.preventDefault();
                          this.closest('form').submit();">
          {{ __('Déconnexion') }}
      </x-responsive-nav-link>
</form>
  </div>
</div>
          </div>
        </div>
      </nav>
        @yield('content')
    </body>
  </html>