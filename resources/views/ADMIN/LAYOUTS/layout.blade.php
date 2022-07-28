<html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <style>
      #mod {
    background-color: #ffffff00;
    border: none;
}
#logo-reglages {
    width: 15px;
}
      </style>
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
                <a class="nav-link" href="/employes">Employés</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/mesConges">Demande de congé</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/depassementHoraire">Dépassement horaire</a>
              </li>
          </ul>
          
          <div style="margin-left: 50%; height:fit-content;">
      <a href = '/resetPass'><button id="mod">
      <img id="logo-reglages" src="https://cdn.discordapp.com/attachments/936584358654005321/973487539618971648/reglages.png" alt="reglages"></button></a>
          <div class="dropdown">
  <button class="dropbtn">{{ Auth::user()->name }}</button>
  <div class="dropdown-content">
<button id="deco"><x-responsive-nav-link :href="route('ficheHoraireUser')">
          {{ __('Espace usager') }}
      </x-responsive-nav-link></button>
      @if(Auth::user()->admin==1 OR Auth::user()->direction==1)
      <button id="deco"><x-responsive-nav-link :href="route('activites')">
          {{ __('Espace Admin') }}
      </x-responsive-nav-link></button>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="margin-bottom: 0;">
@csrf
<button id="deco"><x-responsive-nav-link :href="route('logout')"
              onclick="event.preventDefault();
                          this.closest('form').submit();">
          {{ __('Déconnexion') }}
      </x-responsive-nav-link></button>
</form>
  </div>
</div>
          </div>

        </div>
      </nav>
        @yield('content')
    </body>
  </html>