<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/connection.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>connection</title>
  </head>
  <body>
    <div id="logo1">
        <img id="logo-FS" src="https://media.discordapp.net/attachments/936584358654005321/972050887025508412/LOGO.png?width=820&height=670" alt="Familles de la sarthe">
    </div>
    <div>
        <img id="logo-YC" src="https://media.discordapp.net/attachments/936584358654005321/971697589365911562/unknown.png" alt="YouClock">
    </div>

    <div id="form-connection">
        <p id="bonjour">Bonjour</p>
        <p id="text-con">Connectez-vous pour renseigner votre feuille horaire</p>
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <div class="form-group">
              <x-input id="input-id" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <div class="form-group">
              <x-input id="input-pass" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
              <div id="mdp-oublie">
              <small>
              <a href="https://example.com">Mot de passe oublié ?</a>
              </small>
            </div>
            </div>
            <button type="submit" id="button-con" class="btn btn-primary">CONNECTION</button>
          </form>
    </div>

  </body>
</html>