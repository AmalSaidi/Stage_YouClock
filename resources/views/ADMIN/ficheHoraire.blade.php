
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Fiche horaire</title>

@section('content')
 <div id="button-list">
    
<div class="input-group mb-3">
  <div class="form-outline">
  <form method="post" action="/search" type="get" > <td>
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
        <form id="form2" action="/dureePause/{{ $employe->id }}/export" method="POST">
{{ csrf_field() }}<button>export csv</button></form>
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
    <button id="horaire"disabled>Fiche Horaire</button>
    <button id="ventilation"><a href="/ventilation/{{ $employe->id }}">Ventilation</a></button>
    <button id="stat"><a href="/statistiques/{{ $employe->id }}">Statistiques</a></button>
    @endforeach
</div>  

    <table class="table-bordered" id="fiches">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">Date</th>
      <th scope="col">Statut de la fiche horaire</th>
    </tr>
  </thead>
  <tbody>
     @foreach($fiche as $f)
     <tr>
      <td id="dateFiche">
      @if($f->statutF=="EnCours")  
      {{ $f->idfiche }}
      @else
      <a id="link-nom" href = '/FicheHoraire/Details/{{ $employe->id }}/{{ $f->idfiche }}'>{{ $f->idfiche }}</a>
      @endif
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
    </tr>
     @endforeach
  </tbody>
    </table>
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


  @endsection
