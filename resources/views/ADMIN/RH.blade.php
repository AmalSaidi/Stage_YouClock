@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/RH.css') }}" />
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
  <button id="ajouter" onclick="openForm4(modal2);"> ajouter un employé
</button>
</div>
</div>  
    <div id="acti">

    @foreach( $employes as $employe )

    <div id="pic"><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/974610254220378112/user.png"></div>
      <div id="info-bas">{{ $employe->prenom }} {{ $employe->nom }} <br>
      <div id="struc">{{ $employe->structure }}</div> 
      <div id="statut">En attente de validation du responsable du service</div>
      </div>

      @endforeach   

<br>

<div id="buttons">
<button id="info"><a href='/employes/{{ $employe->id }}'>Informations personnelles</a></button>
<button id="RH" disabled>Dossier RH</button>
<button id="horaire"><a href="">Fiche Horaire</a></button>
<button id="ventilation"><a href="">Ventilation</a></button>
<button id="stat"><a href="">Statistiques</a></button>

</div>

@foreach( $employes as $employe )
<div id="contrat-div">
<div id="section-contrat">
<p style="float:left;">Typologie de contrat</p>
<div id="type-contrat"><small>Type de contrat</small><br>{{ $employe->id }}</div>
</select>
<div dropdown-menu id="temps-travail"><small>Temps du contrat</small><br>{{ $employe->nom }}</div>
<div id="joursNonTravail"><small>Jour non travaillé</small><br>{{ $employe->id }}</div>
<div id="semaine-type"><button id="semaineTypeButton" onclick="openForm3(modal);">Semaine type de l\'employé</button></div>
<div id="Heures-mois"><small>Heures à réaliser par mois</small><br>{{ $employe->id }}</div>
</div>
</div>

<div id="coord-div">
<div id="section-coord">
<p style="float:left;"">Fiche métier</p>
<div id="mail"><small>Adresse mail</small><br>{{ $employe->mail }}</div>
<div id="tel"><small>Téléphone fixe</small><br>{{ $employe->mail }}</div>
<div id="service"><small>Service</small><br>{{ $employe->mail }}</div>
</div>
</div>


<div id="duree-div">
<div id="section-duree">
<p style="float:left;">Durée du contrat</p>
<div id="DateEmbauche"><small>Date d\'embauche</small><br>{{ $employe->dateEmbauche }}</div>
<div id="DateFin"><small>Date de fin de période</small><br>{{ $employe->Datefin }}</div>
</div>
</div>

@endforeach

</div>
<div id="ventilation-div">
<div id="section-ventilation">
<p style="float:left;">Ventilations autorisées</p>
<form>
<div id="ventilation-checkbox">
@foreach( $employes as $employe )
<input type="checkbox" id="checkbox">
  <label for="">{{ $employe->Ventilation }}</label><br>
  </div>
  </form>
</div>
</div>


<div id="modal2" class="modal2">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onclick="closeForm4(modal2);">&times;</span>
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
  <div class="modal-content" style="margin-left: 50%;">
    <span class="close2" onclick="closeForm3(modal);">&times;</span>
    <form>
      <H1>Semaine type de l'employé(e) </H1>
      <button id="mod-semaine-type"><img id="logo-reglages" src="https://cdn.discordapp.com/attachments/936584358654005321/973487539618971648/reglages.png" alt="reglages"> Modifier la semaine type</button>
      <br>
      <div id="buttons-type">
      <button id="type-travail">Travaillé</button>
      <button id="type-travail">Travaillé</button>
      <button id="type-travail">Travaillé</button>
      <button id="type-travail">Travaillé</button>
      <button id="type-travail-vendredi">Travaillé</button>
      <button id="type-travail-weekend">    </button>
      <button id="type-travail-weekend">    </button>
</div>
      <table class="table">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">Lun</th>
      <th scope="col">mar</th>
      <th scope="col">merc</th>
      <th scope="col">jeu</th>
      <th scope="col">ven</th>
      <th scope="col">sam</th>
      <th scope="col">dim</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      @for($i=0;$i < 5; $i++)
    <td>
<div id="debutMat">09:00</div>
<div style="FONT-SIZE: x-large;COLOR: GRAY;">|</div>
<div id="finMat">12:30</div>
<div>Déjeuner</div>
<div id="debutAprem">13:30</div>
<div style="FONT-SIZE: x-large;COLOR: GRAY;">|</div>
<div id="finAprem">17:00</div>
</td>
@endfor
<td id="weekend">
      <div></div>
    </td>
    <td id="weekend">
        <div></div>
    </td>
  </tr>
  </tbody>
</table>
  <button type="submit" class="btn btn-primary" id="ajouter-button">Valider</button>
</form>
  </div>
</div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/semaine-type.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
    </script>
@endforeach




  @endsection

  

