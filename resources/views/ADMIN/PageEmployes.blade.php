@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/PageEmployes.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />

@section('content')
<div id="button-list">
    
    <div class="input-group mb-3">
      <input type="text" id="input-action"  placeholder="Action de masse" aria-describedby="basic-addon2">
      <div class="form-outline">
        <input type="search" id="form1" class="form-control" placeholder="Rechercher" />
      </div>
      <!-- <button type="button" class="btn btn-primary">
        <i class="fas fa-search"></i>
      </button> -->
      <input type="text" id="input-stru"  placeholder="Toutes les structures" aria-describedby="basic-addon2">
      <button id="ajouter"> ajouter un employé
    </button>
    </div>
    </div>  
<div id="acti">
        <br>  

        <table class="table-borderless">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col"><input type="checkbox" id="scales" name="scales"></th>
      <th scope="col">Employés</th>
      <th scope="col">Structure</th>
      <th scope="col">Date de début</th>
      <th scope="col">Date de fin</th>
      <th scope="col">Contrat Mensuel</th>
      <th scope="col">Adresse mail</th>
    </tr>
  </thead>
  <tbody>
  @foreach( $employes as $employe )
     
<tr>
      <td id="checkbox"><input type="checkbox" id="scales" name="scales"></td>
      <td><a href = 'employes/{{ $employe->id }}'><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/974610254220378112/user.png">{{ $employe->nom }} {{ $employe->prenom }}</a></td>
      <td><div id="stru">{{ $employe->structure }}</div></td>
      <td>{{ $employe->dateEmbauche }}</td>
      <td>{{ $employe->dateFin }}</td>
      <td>{{ $employe->TypeContrat }}</td>
      <td>{{ $employe->mail }}</td>
    
</tr>
@endforeach          

  </tbody>
</table>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="/employes" method="POST">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="code">Nom</label>
    <input type="text" class="form-control" name="nom" id="code" placeholder="Nom de l'employé">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Prénom</label>
    <input type="text" class="form-control" name="prenom" id="libelle" placeholder="Prénom de l'employé">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Structure</label>
    <input type="text" class="form-control" name="structure" id="poids" placeholder="la structure">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Intitulé</label>
    <input type="text" class="form-control" name="intitule" id="libelle" placeholder="Prénom de l'employé">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Date de début</label>
    <input type="date" class="form-control" name="dateEmbauche" id="poids" placeholder="La date de début">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Date de fin</label>
    <input type="date" class="form-control" name="Datefin" id="poids" placeholder="La date de fin">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contrat mensuel</label>
    <input type="text" class="form-control" name="TypeContrat" id="poids" placeholder="Le contrat mensuel">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Adresse mail</label>
    <input type="text" class="form-control" name="mail" id="poids" placeholder="L'adresse mail">
  </div>
  <button type="submit" class="btn btn-primary" id="ajouter-button">AJOUTER</button>
</form>
  </div>

</div>

    </div>
    <script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
    </script>
  
@endsection
  