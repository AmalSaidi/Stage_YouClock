@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/services.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>modifier service</title>

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
        <p id="fa-titre" style="font-family: cursive;">Modifier le service</p>
        <br>

  <form action = "/services/edit/<?php echo $services[0]->id; ?>" method = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<div class="form-group">
  <label for="code">Libellé de la service</label>
  <input type="text" class="form-control" name = 'libelle' id="lib" value = '<?php echo$services[0]->libellé; ?>'>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Responsable de service</label>
  <select name="responsable" id="struSelect" style="font-size: 1rem;
    width: 100%;
    height: 37;" required>
  <option><?php echo$services[0]->responsable; ?></option>
      @foreach($employes as $emp)
      <option>{{ $emp->nom}} {{ $emp->prenom}} </option>
      @endforeach
    </select>
</div>
<button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
</div>
<script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>


@endsection
  