@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<style>
#menu-reg {
    BACKGROUND-COLOR: WHITE;
    WIDTH: 19%;
    margin-left: 2%;
    margin-top: -94.2%;
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
<div id="acti">
<h3>Fiche Horaires</h3>
<br>
<div id="button-list">
@if($affichage == null)
    <form action="/FicheHoraire" method="POST">
      {{ csrf_field() }}
<button type="submit">Ajouter la fiche horaire</button>
</form>
@endif
</div>  
<div id="calendar">
  <table class="table-bordered" id="MyTable">
  <thead>
    <th>Date</th>
    <th>Activité</th>
    <th>Matin</th>
    <th>Activité</th>
    <th>Après-midi</th>
    <th>Activité</th>
    <th>Soir</th>
    <th>Heures effectués</th>
    <th>Poids</th>
    <th>Ecart jour</th>
    <th>Pointer</th>
  </thead>
  <tbody>
  @foreach( $employes as $employe )
  @foreach( $affichage as $aff)
    @if($employe->nom==$userNom)
      <tr>
      <td><input name="date" type="hidden" value="{{ $aff->Date }}"> {{ $aff->Date }}</input></td>
        <input name="idfiche" type="hidden" value="{{ $aff->idfiche }}"></input>
        <input name="idUser" type="hidden" value="{{ $aff->idUser }}"></input>
        <td><input name="typeM" type="hidden" value="{{ $aff->activite1 }}">{{ $aff->activite1 }}</input></td>
        <td><input name="matin" type="hidden" value ="{{ $aff->matin }}">{{ $aff->matin }}</input></td>
        <td><input name="typeAP" type="hidden" value="{{ $aff->activite2 }}">{{ $aff->activite2 }}</input></td>
        <td><input name="aprem" type="hidden" value="{{ $aff->aprem }}">{{ $aff->aprem }}</input></td>
        <td><input name="typeS" type="hidden" value="{{ $aff->activite3 }}">{{ $aff->activite3 }}</input></td>
        <td><input name="soir" type="hidden"  value="{{ $aff->soir }}">{{ $aff->soir }}</input></td>
        <td><input name="heuresEffec" type="hidden" value="{{ $aff->heuresEffectu }}">{{ $aff->heuresEffectu }} </input></td>
        <td><input name="poids" type="hidden" value="{{ $aff->Poids }}">{{ $aff->Poids }}</input></td>
        <td><input name="ecartJour" type="hidden" value="{{ $aff->ecart }}">{{ $aff->ecart }}</input></td>
        <td><a href = 'FicheHoraire/edit/{{ $aff->id }}'><button>Pointer</button></a></td>
      </tr>
      <input type="hidden" value="{{$p = $p + $aff->heuresEffectu }}">
      <input type="hidden" value="{{$f = $f + $aff->Poids }}">
      <input type="hidden" value="{{$totEcart = $totEcart + $aff->ecart }}">
    @endif
  @endforeach
  @endforeach
 
  </tbody>
</table>
<div style="text-align:center;">
<button id="Valider">Valider</button>
</div>
</div>

<div>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Demande de congé</h3>
    <hr>
    <form action="/demandeConge" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
  <select name="type" id="typeConge">
    <option>
      Congé payé
    </option>
    <option>
      RTT
    </option>
    <option>
      RCR
    </option>
  </select>
  </div>
  <div class="form-group1" style="float:left;">
  <label for="start">Date de début</label><br>
  <input type="date" id="start" name="start">
  </div>
  <div class="form-group2">
  <label for="start">Date de fin</label><br>
  <input type="date" id="fin" name="fin">
  </div>
  <div class="form-group3">
  <label for="start">Date de retour</label><br>
  <input type="date" id="retour" name="retour">
  <p>Nombre de congé : 7j</p>
  </div>
  <button type="submit" class="btn btn-primary" id="ajouter-button">ENVOYER LA DEMANDE</button>
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
    @foreach( $employes as $employe )
@if($employe->nom==$userNom)
<div id="menu-reg">
    <img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/974610254220378112/user.png">
    <BR>
    <div id="info-user"><p>{{ $employe->nom }} {{ $employe->prenom }}</p></div>
<div id="stru-user">{{ $employe->structure }}</div>
<table class="table-borderless">
  <tbody>

  <tr>
      <td>Total des heures effectués : {{$p}}</td>
    </tr>
    <tr>
      <td>Total des heures à effectuer : {{$f}}</td>
    </tr>
    <tr>
      <td>Ecart : {{$totEcart}}</td>
    </tr>
  </tbody>
</table>
</div>
@endif
@endforeach
    <script>

      </script>
      <script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
       <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
      </script>
      
@endsection
  