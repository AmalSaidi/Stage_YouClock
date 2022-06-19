
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/infoPerso.css') }}" />
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
    <div id="acti">
    @foreach( $employes as $employe )

<div id="pic"><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/974610254220378112/user.png"></div>
  <div id="info-bas">{{ $employe->prenom }} {{ $employe->nom }} <br>
  <div id="struc">{{ $employe->structure }}</div> 
  <div id="statut">En attente de validation du responsable du service</div>
  </div>

  @endforeach   
  <BR>
<div id="buttons">
<button id="info" disabled>informations personnelles</button>
<button id="RH"><a href ='/RH/{{ $employe->id }}'>Dossier RH</a</button>
<button id="horaire"><a href="/FicheHoraire/{{ $employe->id }}">Fiche Horaire</a></button>
<button id="ventilation"><a href="">Ventilation</a></button>
<button id="stat"><a href="">Statistiques</a></button>

</div>
<div class="section-info-perso"> 


@foreach( $employes as $employe )
<div id="info-div">
<div id="section-id">
<p style="float:left;">Identité</p>
<div id="nom"><small>Prénom</small><br>{{ $employe->prenom }}</div>
<div id="prenom"><small>Nom</small><br>{{ $employe->nom }}</div>
<div id="id-conn"><small>Id de connection</small><br>{{ $employe->id }}</div>
</div>
</div>

<div id="coord-div">
<div id="section-coord">
<p style="float:left;">Coordonnées de Contact</p>
<div id="mail"><small>Adresse mail</small><br>{{ $employe->mail }}</div>
<div id="tel"><small>Téléphone fixe</small><br>{{ $employe->tel }}</div>
</div>
</div>
@endforeach   


</div>


<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form>
  <div class="form-group">
    <label for="code">Nom</label>
    <input type="text" class="form-control" id="code" placeholder="Nom de l'employé">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Prénom</label>
    <input type="text" class="form-control" id="libelle" placeholder="Prénom de l'employé">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Structure</label>
    <input type="text" class="form-control" id="poids" placeholder="la structure">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Date de début</label>
    <input type="date" class="form-control" id="poids" placeholder="La date de début">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Date de fin</label>
    <input type="date" class="form-control" id="poids" placeholder="La date de fin">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contrat mensuel</label>
    <input type="text" class="form-control" id="poids" placeholder="Le contrat mensuel">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Adresse mail</label>
    <input type="text" class="form-control" id="poids" placeholder="L'adresse mail">
  </div>
  <button type="submit" class="btn btn-primary" id="ajouter-button">AJOUTER</button>
</form>
  </div>

</div>

<div class="modal" id="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onclick="closeForm(modal);">&times;</span>
    <form>
  <div class="form-group">
    <label for="code">Code</label>
    <input type="text" class="form-control" id="code" placeholder="le code de l'activité">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Libellé</label>
    <input type="text" class="form-control" id="libelle" placeholder="le libellé de l'activité">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"> Poids</label>
    <input type="text" class="form-control" id="poids" placeholder="le poids de l'activité">
  </div>
  <button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
  </div>
</div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
    </script>
  
  @endsection

