@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/activites.css') }}" />
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
        <p id="fa-titre" style="font-family: cursive;">Modifier l'activité</p>
        <br>

  <form action = "/activites/edit/<?php echo $activites[0]->id; ?>" method = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<div class="form-group">
  <label for="code">Code</label>
  <input type="text" class="form-control" name = 'code' id="code" value = '<?php echo$activites[0]->code; ?>'>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Libellé</label>
  <input type="text" name = 'libelle' class="form-control" id="libelle" value = '<?php echo$activites[0]->libellé; ?>'>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Poids</label>
  <input type="text" name = 'poids' class="form-control" id="poids" value = '<?php echo$activites[0]->Poids; ?>'>
</div>
<button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
</div>
<script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>


@endsection
  