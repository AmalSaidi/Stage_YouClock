
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/ventilation.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>ventilation</title>

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
    <button id="horaire"><a href ='/FicheHoraire/{{ $employe->id }}'>Fiche Horaire</a></button>
    <button id="ventilation"><a href="/ventilation/{{ $employe->id }}" style="color:white;">Ventilation</a></button>
    <button id="stat"><a href="/statistiques/{{ $employe->id }}">Statistiques</a></button>
    @endforeach
</div>  

    <table class="table-bordered" id="fiches">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">Ventilation analytique</th>
      <th scope="col">Temps</th>
    </tr>
  </thead>
  <tbody>
  <tr>
        <td>FRASAD</td>
        <td>{{$FRASAD}}</td>
    </tr>
    <tr>
        <td>Entraide familiale</td>
        <td>{{$Entraide}}</td>
    </tr>
    <tr>
        <td>Fédération</td>
        <td>{{$Fédération}}</td>
    </tr>
    <tr>
        <td>Prestataire</td>
        <td>{{$Prestataire}}</td>
    </tr>
    <tr>
        <td>Voisineurs</td>
        <td>{{$Voisineurs}}</td>
    </tr>
    <tr>
        <td>ADU services</td>
        <td>{{$ADU}}</td>
    </tr>
    <tr>
        <td>Mandataires</td>
        <td>{{$Mandataires}}</td>
    </tr>
    <tr>
        <td>SOS Garde d'enfants</td>
        <td>{{$SOS}}</td>
    </tr>
    <tr>
        <td>ADVM</td>
        <td>{{$ADVM}}</td>
    </tr>
    <tr>
        <td>Délégation</td>
        <td>{{$Délégation}}</td>
    </tr>
  </tbody>
    </table>
    <div id="controle">
        <table id="tableControle">
            <thead>
                <th colspan="2" style="text-align: center;">CONTROLE</th>
            </thead>
            <tbody id="bodContr">
                <tr id="trContr">
                    <td style="PADDING: 5 2 5 10;">Nombre d'heures à effectuer</td>
                    <td style="padding: 1 9 1 10;">{{$poids}}</td>
                </tr>
                <tr id="trContr">
                    <td style="PADDING: 5 2 5 10;">Total effectué dans le mois</td>
                    <td style="padding: 1 9 1 10;">{{$totalVentil}}</td>
                </tr>
                @if($totalVentil==$poids)
                <tr id="trContr" style="background-color:#8bcfa5">
                    <td style="PADDING: 5 2 5 10;">différence</td>
                    <td style="padding: 1 9 1 10;">{{$diff}}</td>
                </tr>
                @foreach($fiche as $f)
                @once
                @php
                $idfiche=$f->idfiche;
                $idUser=$f->idUser;
                @endphp
                </tr>
                <tr id="trContr" style="background-color:white;">
                <form action = "/ventilation/validerVentil" method = "post">
                {{ csrf_field() }}
                <input type="hidden" name="idfiche" value="{{ $idfiche }}">
                <input type="hidden" name="idUser" value="{{ $idUser }}">
                <input type="hidden" name="FRASAD" value="{{ $FRASAD }}">
                <input type="hidden" name="Entraide" value="{{ $Entraide }}">
                <input type="hidden" name="Fédération" value="{{ $Fédération }}">
                <input type="hidden" name="Prestataire" value="{{ $Prestataire }}">
                <input type="hidden" name="Voisineurs" value="{{ $Voisineurs }}">
                <input type="hidden" name="ADU" value="{{ $ADU }}">
                <input type="hidden" name="Mandataires" value="{{ $Mandataires }}">
                <input type="hidden" name="SOS" value="{{ $SOS }}">
                <input type="hidden" name="ADVM" value="{{ $ADVM }}">
                <input type="hidden" name="Délégation" value="{{ $Délégation }}">
                <td colspan="2"id="ValiderFiche"><button id="validerButtonY" type="submit" class="btn btn-primary">valider la fiche</button></td>
                </form>
                </tr>
                @endonce
                @endforeach
                @else
                <tr id="trContr" style="background-color:#d48086;">
                <td style="PADDING: 5 2 5 10;">différence</td>
                    <td style="padding: 1 9 1 10;">{{$diff}}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>



  @endsection

