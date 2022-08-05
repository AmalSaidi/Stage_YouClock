@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/historique.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<title>modifier mes informations</title>

<style>
    #menu-reg {
    BACKGROUND-COLOR: WHITE;
    WIDTH: 19%;
    margin-left: 2%;
    margin-top: 1.7%;
    padding-bottom: 80;
    float: left;
    text-align: center;
}
</style>

@section('content')
@php
$userNom=Auth::user()->name;
$userId=Auth::user()->id;
$NotStarted="notStarted";
$EnCours="EnCours";
$Valide="Valide";
@endphp
@foreach($employes as $emp)
    <div id="menu-reg">
    <img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/1002996904004694057/icons8-utilisateur-96_1.png">
    <BR>
    <div id="info-user"><p>{{ $emp->nom }} {{ $emp->prenom }}</p></div>
<div id="stru-user">{{ $emp->structure }}</div>
</div>
<div id="acti">
@if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
@endif
<h3>Modifier mes informations personnelles</h3>
<form action="" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
    <label for="code">Nom</label>
    <input type="text" class="form-control" name="nom" id="code" value="{{ $emp->nom }}">
    <label for="code">Prenom</label>
    <input type="text" class="form-control" name="prenom" id="code" value="{{ $emp->prenom }}">
  </div>
    <div class="form-group">
    <label for="code">Adresse mail</label>
    <input type="text" class="form-control" name="mail" id="code" value="{{ $emp->mail }}">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Télephone</label>
    <input type="text" class="form-control" name="tel" id="libelle" placeholder="{{ $emp->tel }}">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"> Type contrat</label>
    <select name="TypeContrat" id="struSelect">
    <option>CDI</option>
    <option>CDD</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"> Structure</label>
    <select name="structure" id="struSelect">
    <option>{{  $emp->structure }} </option>
      @foreach($structures as $stru)
      <option>{{ $stru->libellé}} </option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"> Service</label>
    <select name="service" id="struSelect">
    <option>{{  $emp->service }} </option>
      @foreach($services as $ser)
      <option>{{ $ser->libellé}} </option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"> Date Embauche</label>
    <input type="date" class="form-control" name="dateEmbauche" id="poids" placeholder="{{ $emp->dateEmbauche }}" value="{{ $emp->dateEmbauche }}">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"> Date Fin</label>
    <input type="date" class="form-control" name="Datefin" id="poids" placeholder="{{ $emp->Datefin }}" value="{{ $emp->Datefin }}">
  </div>
  <div style="text-align:center;">
  <button type="submit" class="btn btn-primary" id="modifierInfo">Mettre à jour les  informations personnelles</button>
</div>
</form>
@endforeach

</div>
@endsection
  