@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/historique.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
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
<h3>Historique</h3>
<table class="table-bordered">
<tbody>
    <th>Date</th>
    <th>Statut</th>
</tbody>
@foreach($fiiche as $f)
<tr>
    <td id="DateF"><a id="link-nom" href = '/historiqueDetails/{{ $f->idfiche }}'>{{ $f->idfiche }}</a></td>
    @if($f->statutF=="EnCours")
  <td><div id="encours">EN COURS</div></td>
  @elseif($f->statutF=="AttValiRS")
  <td><div id="enAttRS">EN ATTENTE VALIDATION RESPONSABLE SERVICE </div></td>
  @elseif($f->statutF=="valideRS")
  <td><div id="valideRS"> VALIDÉ PAR RESPONSABLE DE SERVICE</div></td>
  @else
  <td><div id="valide">VALIDÉ</div></td>
  @endif
</tr>
@endforeach
</table>

</div>
@endsection
  