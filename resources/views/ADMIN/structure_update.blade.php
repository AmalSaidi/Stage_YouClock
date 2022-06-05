@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/structures.css') }}" />
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
        <p id="fa-titre" style="font-family: cursive;">Modifier la structure</p>
        <br>

<form action = "/structures/edit/<?php echo $structures[0]->id; ?>" method = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<div class="form-group">
  <label for="code">Libellé</label>
  <input type="text" class="form-control" name = 'libelle' id="libelle" value = '<?php echo$structures[0]->libellé; ?>'>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Code</label>
  <input type="text" name = 'code' class="form-control" id="libelle" value = '<?php echo$structures[0]->code; ?>'>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Congé Payé</label>
  <input type="text" name = 'congePaye' class="form-control" id="poids" value = '<?php echo$structures[0]->congePaye; ?>'>
</div>
<button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
</div>
<script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>


@endsection