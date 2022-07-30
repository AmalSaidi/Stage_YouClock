@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/semainetype.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Semaine type</title>

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
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    @foreach( $employes as $employe )

<div id="pic"><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/1002996904004694057/icons8-utilisateur-96_1.png"></div>
  <div id="info-bas">{{ $employe->prenom }} {{ $employe->nom }} <br>
  <div id="struc">{{ $employe->structure }}</div> 
  <div id="statut">En attente de validation du responsable du service</div>
  </div> 

<br>

<div id="buttons">
<button id="info"><a href='/employes/{{ $employe->id }}'>Informations personnelles</a></button>
<button id="RH" disabled>Dossier RH</button>
<button id="horaire"><a href="/FicheHoraire/{{ $employe->id }}">Fiche Horaire</a></button>
<button id="ventilation"><a href="">Ventilation</a></button>
<button id="stat"><a href="">Statistiques</a></button>

</div>
    <h4 id="stTitre">
        modifier la semaine type
</h4>
    <table class="table-bordered">
<thead class="thead-dark">
<th></th>
<th>Matin</th>
<th>Après-midi</th>
<th>Soir</th>
</thead>
<tbody>
    <form action="" method="POST">
    {{ csrf_field() }}
    <tr>
        <td><input name="Lun" type="hidden" value="Lundi"/>Lundi</td> 
        <input name="identifiant"type="hidden" value="{{ $employe->identifiant }}"/>
        <td>
            <input name="DM1" type="time"/> -  <input name="FM1" type="time"/>
        </td>
        <td>
            <input name="DA1" type="time"/> -  <input name="FA1" type="time"/>
        </td>
        <td>
            <input name="DS1" type="time"/> -  <input name="FS1" type="time"/>
        </td>
    </tr>
    <tr>
    <td><input name="Mar"type="hidden" value="Mardi"/>Mardi</td> 
    <input name="identifiant2"type="hidden" value="{{ $employe->identifiant }} "/>
        <td>
            <input name="DM2"type="time"/> -  <input name="FM2" type="time"/>
        </td>
        <td>
            <input name="DA2" type="time"/> -  <input name="FA2" type="time"/>
        </td>
        <td>
            <input name="DS2" type="time"/> -  <input name="FS2" type="time"/>
        </td>
    </tr>
    <tr>
    <td><input name="Mer"type="hidden" value="Mercredi"/>Mercredi</td> 
    <input name="identifiant3"type="hidden" value="{{ $employe->identifiant }} "/>
        <td>
            <input name="DM3"type="time"/> -  <input name="FM3" type="time"/>
        </td>
        <td>
            <input name="DA3" type="time"/> -  <input name="FA3" type="time"/>
        </td>
        <td>
            <input name="DS3" type="time"/> -  <input name="FS3" type="time"/>
        </td>
    </tr>
    <tr>
    <td><input name="Jeu"type="hidden" value="Jeudi"/>Jeudi</td> 
    <input name="identifiant4"type="hidden" value="{{ $employe->identifiant }} "/>
        <td>
            <input name="DM4"type="time"/> -  <input name="FM4" type="time"/>
        </td>
        <td>
            <input name="DA4" type="time"/> -  <input name="FA4" type="time"/>
        </td>
        <td>
            <input name="DS4" type="time"/> -  <input name="FS4" type="time"/>
        </td>
    </tr>
    <tr>
    <td><input name="Ven"type="hidden" value="Vendredi"/>Vendredi</td> 
    <input name="identifiant5"type="hidden" value="{{ $employe->identifiant }} "/>
        <td>
            <input name="DM5"type="time"/> -  <input name="FM5" type="time"/>
        </td>
        <td>
            <input name="DA5" type="time"/> -  <input name="FA5" type="time"/>
        </td>
        <td>
            <input name="DS5" type="time"/> -  <input name="FS5" type="time"/>
        </td>
    </tr>
    <tr>
    <td><input name="Sam"type="hidden" value="Samedi"/>Samedi</td> 
    <input name="identifiant6"type="hidden" value="{{ $employe->identifiant }} "/>
        <td>
            <input name="DM6"type="time"/> -  <input name="FM6" type="time"/>
        </td>
        <td>
            <input name="DA6" type="time"/> -  <input name="FA6" type="time"/>
        </td>
        <td>
            <input name="DS6" type="time"/> -  <input name="FS6" type="time"/>
        </td>
    </tr>
    <tr>
    <td><input name="Dim"type="hidden" value="Dimanche"/>Dimanche</td> 
    <input name="identifiant7"type="hidden" value="{{ $employe->identifiant }} "/>
        <td>
            <input name="DM7"type="time"/> -  <input name="FM7" type="time"/>
        </td>
        <td>
            <input name="DA7" type="time"/> -  <input name="FA7" type="time"/>
        </td>
        <td>
            <input name="DS7" type="time"/> -  <input name="FS7" type="time"/>
        </td>
    </tr>
</tbody>
    </table>
    <div id="valideDiv">
    <button class="btn btn-success" type="submit">Valider</button>
    </div>
</form>
    </div>


    @endforeach  
  @endsection