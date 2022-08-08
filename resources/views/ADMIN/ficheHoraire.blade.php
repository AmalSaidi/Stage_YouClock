
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Fiche horaire</title>

@section('content')
 <div id="button-list">
    
<div class="input-group mb-3">
  <div class="form-outline">
  <form method="post" action="" type="get" > <td>
                {{ csrf_field() }}
        <input type="search" id="form1" name="search" class="form-control" placeholder="Rechercher" />
      </form>
  </div>
  <!-- <button type="button" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button> -->
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
        @if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
@endif
        <form method="post" action="/searchFiche/{{$employe->id}}" type="get" > <td>
                {{ csrf_field() }}
        <select name="searchfiche" onchange="this.form.submit()" style="float:right;">
        <option value="" disabled selected>Rechercher</option>
        @php
    $year = date("Y");
    $yearArr = array();
    @endphp
    @for ($i = 0; $i < 30; $i++)
    @php
    $yearArr[$i] = $year -$i;
    @endphp
    <option value="{{$yearArr[$i]}}">{{$yearArr[$i]}}</option>
    @endfor
        @endphp
        </select>
      </form>
          <!--
        @foreach($fiche as $f)
        <form id="form2" action="/Fichehoraire/{{ $employe->id }}/export" method="POST">
        {{ csrf_field() }}
<input type="hidden" name="idF" value="{{$f->idfiche}}"/>
<input type="hidden" name="statutF" value="{{$f->statutF}}"/>
<input type="hidden" name="idUser" value="{{$f->idUser}}"/>
<input type="hidden" name="nom" value="{{$employe->nom}}"/>
<input type="hidden" name="prenom" value="{{$employe->prenom}}"/>
@endforeach
<button id="export"> Export CSV <img id="logo-reglages" src="/images/downald.png" alt="reglages">
</button>
</form>
-->
        <div id="pic"><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/1002996904004694057/icons8-utilisateur-96_1.png"></div>
      <div id="info-bas">{{ $employe->prenom }} {{ $employe->nom }} <br>
      <div id="struc">{{ $employe->structure }}</div> 
      @foreach($fiiche as $f)
  @if($f->statutF=="EnCours")
  <div id="encourss" class="encours">En cours</div>
  @elseif($f->statutF=="AttValiRS")
  <div id="enAttRSS" class="enAttRS">En attente de validation responsable de service</div>
  @elseif($f->statutF=="valideRS")
  <div id="valideRSS" class="valideRS">Validé par responsable de service</div>
  @else
  <div id="validee" class="valide">Validé</div>
  @endif
  @endforeach
      </div>
      <br>
    <div id="buttons">
    <button id="info"><a href ='/employes/{{ $employe->id }}'>Informations personnelles</a></button>
    <button id="RH"><a href ='/RH/{{ $employe->id }}'>Dossier RH</a></button>
    <button id="horaire"><a href="/FicheHoraire/{{ $employe->id }}" style="color:white;">Fiche Horaire</a></button>
    <button id="ventilation"><a href="/ventilation/{{ $employe->id }}">Ventilation</a></button>
    <button id="stat"><a href="/statistiques/{{ $employe->id }}">Statistiques</a></button>
    @endforeach
</div>
@if(Auth::user()->direction==1)
<button id="ajouter" class="btn btn-danger">Ajouter une fiche horaire</button>
@endif
    <table class="table-bordered" id="fiches" style="margin-top:1%;">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">Date</th>
      <th scope="col">Statut de la fiche horaire</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
     @foreach($fiche as $f)
     <tr>
      <td id="dateFiche">
      <a id="link-nom" href = '/FicheHoraire/Details/{{ $employe->id }}/{{ $f->idfiche }}'>{{ $f->idfiche }}</a>
  </td>
  <td id="statut2">
  @if($f->statutF=="EnCours")
  <div id="encours">EN COURS</div>
  @elseif($f->statutF=="AttValiRS")
  <div id="enAttRS">EN ATTENTE VALIDATION RESPONSABLE SERVICE </div>
  @elseif($f->statutF=="valideRS")
  <div id="valideRS"> VALIDÉ PAR RESPONSABLE DE SERVICE</div>
  @else
  <div id="valide">VALIDÉ</div>
  @endif
  
  </td>
  <td>
  <form id="form2" action="/Fichehoraire/{{ $employe->id }}/export" method="POST">
        {{ csrf_field() }}
<input type="hidden" name="idF" value="{{$f->idfiche}}"/>
<input type="hidden" name="statutF" value="{{$f->statutF}}"/>
<input type="hidden" name="idUser" value="{{$f->idUser}}"/>
<input type="hidden" name="nom" value="{{$employe->nom}}"/>
<input type="hidden" name="prenom" value="{{$employe->prenom}}"/>
<button id="export"> Export CSV <img id="logo-reglages" src="/images/downald.png" alt="reglages">
</button>
</form>
  </td>
    </tr>
     @endforeach
  </tbody>
    </table>

    <div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content" style="margin-top: 8%;">
  <span class="close">&times;</span>
  <form action="/ajouterFiche" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="identifiant" value="{{$employe->identifiant}}"/>
<div class="form-group">
  <label for="exampleInputPassword1">Année</label>
  <select name="annee" id="select">
  @php
  $year = date("Y");
  $yearArr = array();
  @endphp
  @for ($i = 0; $i < 30; $i++)
  @php
  $yearArr[$i] = $year -$i;
  @endphp
  <option value="{{$yearArr[$i]}}">{{$yearArr[$i]}}</option>
  @endfor

      @endphp
</select>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Mois</label>
  <select name="mois" id="select">
<option value="01">Janvier</option>
<option value="02">Février</option>
<option value="03">Mars</option>
<option value="04">Avril</option>
<option value="05">Mai</option>
<option value="06">Juin</option>
<option value="07">Juillet</option>
<option value="08">Août</option>
<option value="09">Septembre</option>
<option value="10">Octobre</option>
<option value="11">Novembre</option>
<option value="12">Décembre</option>
</select>
</div>
<button type="submit" class="btn btn-danger" id="add">AJOUTER</button>
</form>
</div>

</div>
    <script>
$("#form2").on("submit", function (e) {
    var dataString = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "structures",
      data: dataString,
      success: function () {
      }
    });
    e.preventDefault();
});
</script>
<script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
       <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">

  @endsection
