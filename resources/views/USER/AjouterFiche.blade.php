@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/historique.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<title>historique</title>

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
@endforeach
<div id="acti">
<h3>Ajouter une fiche horaire</h3>
<form action="/historique/ajouterFiche" method="POST">
{{ csrf_field() }}
<select name="année">
 <option value="2022">2022</option>
 </select>
 <select name="Mois">
 <option value="Janvier">Janvier</option>
 </select>
<button id="ajouterFiche" type="submit" class="btn btn-danger">Ajouter la fiche</div>
</form>
</div>
@endsection
  