
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />

@section('content')
 <div id="button-list">
    
<div class="input-group mb-3">
  <div class="form-outline">
    <input type="search" id="form1" class="form-control" placeholder="Rechercher" />
  </div>
  <!-- <button type="button" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button> -->
  <button id="ajouter"> ajouter un employé
</button>
</div>
</div>  
    <div id="menu-reg">
<table class="table-borderless">
  <tbody>
  @foreach( $employees as $emp )
    <tr>
      <td><a id="link-nom" href = '/employes/{{ $emp->id }}'>{{ $emp->nom }} {{ $emp->prenom }} </a><br>
        <small>{{ $emp->structure }}</small>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
    @foreach( $employes as $employe )
        <div id="acti">
        <div id="pic"><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/974610254220378112/user.png"></div>
      <div id="info-bas">{{ $employe->prenom }} {{ $employe->nom }} <br>
      <div id="struc">{{ $employe->structure }}</div> 
      <div id="statut">En attente de validation du responsable du service</div>
      </div>
      <br>
    <div id="buttons">
    <button id="info"><a href ='/employes/{{ $employe->id }}'>Informations personnelles</a></button>
    <button id="RH"><a href ='/RH/{{ $employe->id }}'>Dossier RH</a></button>
    <button id="horaire"disabled>Fiche Horaire</button>
    <button id="ventilation"><a href="">Ventilation</a></button>
    <button id="stat"><a href="">Statistiques</a></button>
    @endforeach
</div>  

    <table class="table-bordered" id="fiches">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">Date</th>
      <th scope="col">Statut de la fiche horaire</th>
      <th scope="col" id="hidden"></th>
    </tr>
  </thead>
  <tbody>
     @foreach($fiche as $f)
     <tr>
      <td>  
      <a id="link-nom" href = '/FicheHoraire/Details/{{ $employe->id }}/{{ $f->idfiche }}'>{{ $f->idfiche }}</a>
  </td>
  <td>
  @if($f->statutF=="EnCours")
  En Cours
  @else
  Valide
  @endif
  </td>
    </tr>
     @endforeach
  </tbody>
    </table>



  @endsection

