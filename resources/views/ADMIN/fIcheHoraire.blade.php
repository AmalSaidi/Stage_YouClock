
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
    @foreach( $employes as $employe )
    
        <div id="acti">
    <div id="buttons">
    <button id="info" disabled>informations personnelles</button>
    <button id="RH"><a href ='/RH/{{ $employe->id }}'>Dossier RH</a</button>
    <button id="horaire"><a href="">Fiche Horaire</a></button>
    <button id="ventilation"><a href="">Ventilation</a></button>
    <button id="stat"><a href="">Statistiques</a></button>
    
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
    <div id="acti">
    <table class="table-bordered">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">Date</th>
      <th scope="col">Statut de la fiche horaire</th>
      <th scope="col" id="hidden"></th>
    </tr>
  </thead>
  <tbody>

  
    </div>



  @endsection

