
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/ficheHoraireDetails.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
@section('content')
@php
$T=0;
$P=0;
$F=0;
$DIF=0;
@endphp
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
    @foreach( $employes as $employe )
        <div id="acti">
            
          <div id="pic"><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/974610254220378112/user.png"></div>
      <div id="info-bas">{{ $employe->prenom }} {{ $employe->nom }} <br>
      <div id="struc">{{ $employe->structure }}</div> 
      <div id="statut">En attente de validation du responsable du service</div>
      </div>
      <br>
    <div id="buttons">
    <button id="info"><a href ='/employes/{{ $employe->id }}'>Informations personnelles</a></button>
    <button id="RH"><a href ='/RH/{{ $employe->id }}'>Dossier RH</a></button>
    <button id="horaire"disabled>Fiche Horaire</button>
    <button id="ventilation"><a href="">Ventilation</a></button>
    <button id="stat"><a href="">Statistiques</a></button>
    @endforeach
</div>
    <table class="table" id="tableFiche1">
        <thead id="headFiche">
            <th>Date</th>
            <th>Activité</th>
            <th>Nb heures</th>
            <th>Poids</th>
            <th>Ecart</th>
            <th style="background-color:#b1eab1;">Valider</th>
            <th style="background-color:#eab1b3;">Refuser</th>
        </thead>
    <tbody>
    @foreach($fiche as $f)
    @if( $f->activite1 =="T")
    @php 
    $T=$T+1 
    @endphp
    @endif
    <tr>
            <td>{{ $f->Date }}</td>
            <td>{{ $f->activite1 }}</td>
            <td>{{ $f->heuresEffectu }}</td>
            <td>{{ $f->Poids }}</td>
            <td>{{ $f->ecart }}</td>
            <td>
            <input type="checkbox"></input>
            </td>
            <td><input type="checkbox"></input></td>
            @php
            $F = $F + $f->heuresEffectu;
            $P = $P + $f->Poids;
            @endphp
        </tr>
     @if($loop->iteration ==8 or $loop->iteration ==15 or $loop->iteration ==22 or $loop->iteration ==29)
    <tr id="depass"><td colspan="2">Depassement autorisé :</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
    @endif
    @if($loop->iteration == 22)
    @break
    @endif
    @endforeach
    </tbody>
    </table>
    <table class="table" id="tableFiche2">
        <thead id="headFiche">
            <th>Date</th>
            <th>Activité</th>
            <th>Nb heures</th>
            <th>Poids</th>
            <th>Ecart</th>
            <th style="background-color:#b1eab1;">Valider</th>
            <th style="background-color:#eab1b3;">Refuser</th>
        </thead>
    <tbody>
    @foreach($fiche as $f)
    @if($loop->iteration > 22)
    <tr>
            <td>{{ $f->Date }}</td>
            <td>{{ $f->activite1 }}</td>
            <td>{{ $f->heuresEffectu }}</td>
            <td>{{ $f->Poids }}</td>
            <td>{{ $f->ecart }}</td>
            <td>
            <input type="checkbox"></input>
            </td>
            <td><input type="checkbox"></input></td>
            @php
            $F = $F + $f->heuresEffectu;
            $P = $P + $f->Poids;
            @endphp
        </tr>
    @if($loop->iteration ==8 or $loop->iteration ==15 or $loop->iteration ==22 or $loop->iteration ==29)
    <tr id="depass"><td colspan="2">Depassement autorisé :</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
    @endif
    @endif
    @endforeach
    </tbody>
    </table>

    <div id="stats">
       <table id="tableStats">
           <tr id="trT">
               <td id="Fer">{{$T}}.00</td>
               <td id="typeStat">Férié (jour)</td>
           </tr>
           <tr id="trT">
               <td id="tra">0.00</td>
               <td id="typeStat">Travaillé (jour)</td>
           </tr>
           <tr id="trT">
               <td id="cp">0.00</td>
               <td id="typeStat">CP (jour)</td>
           </tr>
           <tr id="trT">
               <td id="RTT">0.00</td>
               <td id="typeStat">RTT (jour)</td>
           </tr>
           <tr>
               <td id="HRTT">0.00</td>
               <td id="typeStat">1/2 RTT (jour)</td>
           </tr>
           <tr id="trT">
               <td id="RCR">0.00</td>
               <td id="typeStat">RCR (jour)</td>
           </tr>
           <tr id="trT">
               <td id="forma">0.00</td>
               <td id="typeStat">Fomation (jour)</td>
           </tr>
           <tr id="trT">
               <td id="malad">0.00</td>
               <td id="typeStat">Maladie (jour)</td>
           </tr>
           <tr id="trT">
               <td id="CF">0.00</td>
               <td id="typeStat">Congés familiaux (jour)</td>
           </tr>
           <tr id="trT">
               <td id="SS">0.00</td>
               <td id="typeStat">Sans soldes (jour)</td>
           </tr>
           <tr id="trT">
               <td id="js">0.00</td>
               <td id="typeStat">Jour solidarité</td>
           </tr>
       </table>
    </div>
    <div id="controle">
        <table id="tableControle">
            <thead>
                <th colspan="2" style="text-align: center;">CONTRÖLE</th>
            </thead>
            <tbody id="bodContr">
                <tr id="trContr">
                    <td style="PADDING: 5 2 5 10;">Nombre d'heures à effectuer</td>
                    <td style="padding: 1 9 1 10;">{{$P}}.00</td>
                </tr>
                <tr id="trContr">
                    <td style="PADDING: 5 2 5 10;">Total effectué dans le mois</td>
                    <td style="padding: 1 9 1 10;">{{$F}}.00</td>
                </tr>
                @php
                $DIF=$P-$F;
                @endphp
                @if($DIF==0)
                <tr id="trContr" style="background-color:#8bcfa5">
                    <td style="PADDING: 5 2 5 10;">différence</td>
                    <td style="padding: 1 9 1 10;">{{$DIF}}.00</td>
                </tr>
                @else
                <tr id="trContr" style="background-color:#d48086;">
                <td style="PADDING: 5 2 5 10;">différence</td>
                    <td style="padding: 1 9 1 10;">{{$DIF}}.00</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
        </div>
  @endsection

