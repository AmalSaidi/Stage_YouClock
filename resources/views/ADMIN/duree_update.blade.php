@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/dureePause.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />

@section('content')
<div id="menu-reg">
    <P id="reglages">Réglages</P>
    <ul class="nav flex-column">
    <li class="reg" >
        <a class="nav-link" href="/activites">ACTIVITES</a>
      </li>
      <li class="reg" >
        <a class="nav-link" href="/structures">STRUCTURES</a>
      </li>
      <li class="reg" >
        <a class="nav-link" href="/services">SERVICES</a>
      </li>
      <li class="reg">
        <a class="nav-link" href="/dureePause">DUREE DES PAUSES</a>
      </li>
    </ul>
  </div>
  <div id="acti">
        <p id="fa-titre" style="font-family: cursive;">Modifier la durée de pause</p>
        <br>

  <form action = "/dureePause/edit/<?php echo $duree[0]->id; ?>" method = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

  <input type="text" id="pause" name = 'pause' class="form-control" value = '<?php echo$duree[0]->pause; ?>'>
<button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
</div>
<script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>


@endsection
  