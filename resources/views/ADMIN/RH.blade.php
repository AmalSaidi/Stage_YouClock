@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/RH.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Dossier RH</title>

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
    <div id="acti">

    @foreach( $employes as $employe )

    <div id="pic"><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/1002996904004694057/icons8-utilisateur-96_1.png"></div>
      <div id="info-bas">{{ $employe->prenom }} {{ $employe->nom }} <br>
      <div id="struc">{{ $employe->structure }}</div> 
      @foreach($fiche as $f)
  @if($f->statutF=="EnCours")
  <div id="encours" class="encours">En cours</div>
  @elseif($f->statutF=="AttValiRS")
  <div id="enAttRS" class="enAttRS">En attente de validation responsable de service</div>
  @elseif($f->statutF=="valideRS")
  <div id="valideRS" class="valideRS">Validé par responsable de service</div>
  @else
  <div id="valide" class="valide">Validé</div>
  @endif
  @endforeach
      </div>

      @endforeach   

<br>

<div id="buttons">
<button id="info"><a href='/employes/{{ $employe->id }}'>Informations personnelles</a></button>
<button id="RH"><a href ='/RH/{{ $employe->id }}'style="color:white;">Dossier RH</a</button>
<button id="horaire"><a href="/FicheHoraire/{{ $employe->id }}">Fiche Horaire</a></button>
<button id="ventilation"><a href="/ventilation/{{ $employe->id }}">Ventilation</a></button>
<button id="stat"><a href="/statistiques/{{ $employe->id }}">Statistiques</a></button>

</div>

@foreach( $employes as $employe )
<div id="contrat-div">
<div id="section-contrat">
<p style="float:left;">Typologie de contrat</p>
<div id="type-contrat"><small>Type de contrat</small><br>{{ $employe->TypeContrat }}</div>
</select>
<div dropdown-menu id="temps-travail"><small>Temps du contrat</small><br>Temps Partiel</div>
<div id="joursNonTravail"><small>Jour non travaillé</small><br>Mercredi</div>
<div id="semaine-type"><button id="semaineTypeButton" onclick="openForm3(modal);">Semaine type de l'employé</button></div>
<div id="Heures-mois"><small>Heures à réaliser par mois</small><br>35</div>
</div>
</div>

<div id="coord-div">
<div id="section-coord">
<p style="float:left;">Fiche métier</p>
<div id="mail"><small>Intitulé du poste</small><br>{{ $employe->intitule }}</div>
<div id="tel"><small>Structure</small><br>{{ $employe->structure }}</div>
<div id="service"><small>Service</small><br>{{ $employe->service }}</div>
</div>
</div>


<div id="duree-div">
<div id="section-duree">
<p style="float:left;">Durée du contrat</p>
<div id="DateEmbauche"><small>Date d\'embauche</small><br>{{ $employe->dateEmbauche }}</div>
<div id="DateFin"><small>Date de fin de période</small><br>{{ $employe->Datefin }}</div>
</div>
</div>

<div id="duree-div">
<div id="section-duree">
<form action="" method="POST">
    {{ csrf_field() }}
<p style="float:left;">Ventilation</p>
<div id="venti">
<input type="hidden" name="idUser" value="{{$employe->identifiant}}">
<input type="checkbox" value="FRASAD" name="ventilation[]">
      <label for="FRASAD">FRASAD</label>
      <br>
      <input type="checkbox" value="Entraide familiale" name="ventilation[]">
      <label for="Entraide familiale">Entraide familiale</label>
      <br>
      <input type="checkbox" value="Federation" name="ventilation[]">
      <label for="Federation">Fédération</label>
      <br>

</div>
      <div id="venti2">
      <input type="checkbox" value="Prestataire" name="ventilation[]">
             <label for="Prestataire">Prestataire</label>
             <br>
      <input type="checkbox" value="Voisineurs" name="ventilation[]">
             <label for="Voisineurs">Voisineurs</label>
             <br>
      <input type="checkbox" value="ADU services" name="ventilation[]">
      <label for="ADU services">ADU services</label>
      <br>
      </div>
      <div id="venti3">
      <input type="checkbox" value="Mandataires" name="ventilation[]">
      <label for="Mandataires">Mandataires</label>
      <br>

      <input type="checkbox" value="SOS garde d'enfants" name="ventilation[]">
      <label for="SOS garde d'enfants">SOS garde d'enfants</label>
     <br>
      <input type="checkbox" value="ADVM" name="ventilation[]"
      > <label for="ADVM">ADVM</label>

</div>
<div id="venti4">
<input type="checkbox" value="DELEGATION" name="ventilation[]"
      > <label for="DELEGATION">DELEGATION</label>

</div>
<br>
      <div id="maj-venti"><button type=submit class="btn btn-success">Mettre à jour la ventilation</button></div>
</form>
</div>
</div>

@endforeach

</div>

@foreach( $employes as $employe )


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
    <span class="close" onclick="closeForm3(modal);">&times;</span>
    <form>
      <h4 id="idST" style="font-family: fangsong;">Semaine type de l'employé(e) </H4>
      
     <div id="mod-semaine-type" style="width:fit-content;"> <a href="/RH/semaineType/{{ $employe->id }}" id="linkBU" style="color:black;"><img id="logo-reglages" src="https://cdn.discordapp.com/attachments/936584358654005321/973487539618971648/reglages.png" alt="reglages"> Modifier la semaine type</a></div>
      <br>
<table class="table-bordered">
<thead class="thead-dark">
<th></th>
<th>Matin</th>
<th>Après-midi</th>
<th>Soir</th>
</thead>
<tbody>
@foreach($Lun as $lun)
    <tr>
        <td><input name="Lun" type="hidden" value="Lundi"/>Lundi</td> 
        <td>
            <input name="DM1" type="time" value="{{$lun->DM}}" disabled/> -  <input name="FM1" type="time" value="{{$lun->FM}}" disabled/>
        </td>
        <td>
            <input name="DA1" type="time" value="{{$lun->DA}}" disabled/> -  <input name="FA1" type="time" value="{{$lun->FA}}" disabled/>
        </td>
        <td>
            <input name="DS1" type="time" value="{{$lun->DS}}" disabled/> -  <input name="FS1" type="time" value="{{$lun->FS}}" disabled/>
        </td>
    </tr>
  @endforeach
  @foreach($Mar as $mar)
    <tr>
        <td><input name="Mar" type="hidden" value="Mardi"/>Mardi</td> 
        <td>
            <input name="DM1" type="time" value="{{$mar->DM}}" disabled/> -  <input name="FM1" type="time" value="{{$mar->FM}}" disabled/>
        </td>
        <td>
            <input name="DA1" type="time" value="{{$mar->DA}}" disabled/> -  <input name="FA1" type="time" value="{{$mar->FA}}" disabled/>
        </td>
        <td>
            <input name="DS1" type="time" value="{{$mar->DS}}" disabled/> -  <input name="FS1" type="time" value="{{$mar->FS}}" disabled/>
        </td>
    </tr>
  @endforeach
  @foreach($Mer as $mer)
    <tr>
        <td><input name="Mer" type="hidden" value="Mercredi"/>Mercredi</td> 
        <td>
            <input name="DM1" type="time" value="{{$mer->DM}}" disabled/> -  <input name="FM1" type="time" value="{{$mer->FM}}" disabled/>
        </td>
        <td>
            <input name="DA1" type="time" value="{{$mer->DA}}" disabled/> -  <input name="FA1" type="time" value="{{$mer->FA}}" disabled/>
        </td>
        <td>
            <input name="DS1" type="time" value="{{$mer->DS}}" disabled/> -  <input name="FS1" type="time" value="{{$mer->FS}}" disabled/>
        </td>
    </tr>
  @endforeach
  @foreach($Jeu as $jeu)
    <tr>
        <td><input name="Jeu" type="hidden" value="Jeudi"/>Jeudi</td> 
        <td>
            <input name="DM1" type="time" value="{{$jeu->DM}}" disabled/> -  <input name="FM1" type="time" value="{{$jeu->FM}}" disabled/>
        </td>
        <td>
            <input name="DA1" type="time" value="{{$jeu->DA}}" disabled/> -  <input name="FA1" type="time" value="{{$jeu->FA}}" disabled/>
        </td>
        <td>
            <input name="DS1" type="time" value="{{$jeu->DS}}" disabled/> -  <input name="FS1" type="time" value="{{$jeu->FS}}" disabled/>
        </td>
    </tr>
  @endforeach
  @foreach($Ven as $ven)
    <tr>
        <td><input name="Ven" type="hidden" value="Vendredi"/>Vendredi</td> 
        <td>
            <input name="DM1" type="time" value="{{$ven->DM}}" disabled/> -  <input name="FM1" type="time" value="{{$ven->FM}}" disabled/>
        </td>
        <td>
            <input name="DA1" type="time" value="{{$ven->DA}}" disabled/> -  <input name="FA1" type="time" value="{{$ven->FA}}" disabled/>
        </td>
        <td>
            <input name="DS1" type="time" value="{{$ven->DS}}" disabled/> -  <input name="FS1" type="time" value="{{$ven->FS}}" disabled/>
        </td>
    </tr>
  @endforeach
  @foreach($Sam as $sam)
    <tr>
        <td><input name="Sam" type="hidden" value="Samedi"/>Samedi</td> 
        <td>
            <input name="DM1" type="time" value="{{$sam->DM}}" disabled/> -  <input name="FM1" type="time" value="{{$sam->FM}}" disabled/>
        </td>
        <td>
            <input name="DA1" type="time" value="{{$sam->DA}}" disabled/> -  <input name="FA1" type="time" value="{{$sam->FA}}" disabled/>
        </td>
        <td>
            <input name="DS1" type="time" value="{{$sam->DS}}" disabled/> -  <input name="FS1" type="time" value="{{$sam->FS}}" disabled/>
        </td>
    </tr>
  @endforeach
  @foreach($Dim as $dim)
    <tr>
        <td><input name="Dim" type="hidden" value="Dimanche"/>Dimanche</td> 
        <td>
            <input name="DM1" type="time" value="{{$dim->DM}}" disabled/> -  <input name="FM1" type="time" value="{{$dim->FM}}" disabled/>
        </td>
        <td>
            <input name="DA1" type="time" value="{{$dim->DA}}" disabled/> -  <input name="FA1" type="time" value="{{$dim->FA}}" disabled/>
        </td>
        <td>
            <input name="DS1" type="time" value="{{$dim->DS}}" disabled/> -  <input name="FS1" type="time" value="{{$dim->FS}}" disabled/>
        </td>
    </tr>
  @endforeach
</tbody>
    </table>
  </div>
</div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/semaine-type.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
    </script>
@endforeach




  @endsection

  

