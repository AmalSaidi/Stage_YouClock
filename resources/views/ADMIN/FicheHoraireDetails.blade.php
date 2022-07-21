
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/ficheHoraireDetails.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@section('content')
@php
$T=0;
$P=0;
$F=0;
$CP=0;
$RTT=0;
$HRTT=0;
$RCR=0;
$FORMATION=0;
$FER=0;
$MALADIE=0;
$SS=0;
$JS=0;
$CF=0;
$DIF=0;
$DEP=0;
$se1=0;
$se2=0;
$se3=0;
$se4=0;
$se5=0;
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
      @foreach($fiiche as $f)
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
            <th></th>
            <th></th>
        </thead>
    <tbody>
    @foreach($fiche as $f)
    @if( $f->typeJour =="Travaillé")
    @php 
    $T=$T+1 
    @endphp
    @elseif( $f->typeJour =="Férié")
    @php 
    $FER=$FER+1 
    @endphp
    @elseif( $f->typeJour =="CP")
    @php 
    $CP=$CP+1 
    @endphp
    @elseif( $f->typeJour =="RTT")
    @php 
    $RTT=$RTT+1 
    @endphp
    @elseif( $f->typeJour =="1/2 RTT")
    @php 
    $HRTT=$HRTT+1 
    @endphp
    @elseif( $f->typeJour =="RCR")
    @php 
    $RCR=$RCR+1 
    @endphp
    @elseif( $f->typeJour =="Formation")
    @php 
    $FORMATION=$FORMATION+1 
    @endphp
    @elseif( $f->typeJour =="Maladie")
    @php 
    $MALADIE=$MALADIE+1 
    @endphp
    @elseif( $f->typeJour =="Congés familiaux")
    @php 
    $CF=$CF+1 
    @endphp
    @elseif( $f->typeJour =="Sans soldes")
    @php 
    $SS=$SS+1 
    @endphp
    @elseif( $f->typeJour =="Jour solidarité")
    @php 
    $JS=$JS+1 
    @endphp
    @endif
<tr id="trTab">
        
            <td>{{ $f->Date }}</td>
            <td>{{ $f->typeJour }}</td>
            <td>{{ $f->heuresEffectu }}</td>
            <td>{{ $f->Poids }}</td>
            <td>{{ $f->ecart }}</td>
           
                <form method="post" action="" id="form2" class="fconfirm"> <td>
                {{ csrf_field() }}
                 <input type="hidden" name="id" value="{{$f->id}}">

                 <input type="hidden" name="idfiche" value="{{$f->idfiche}}">

                <button type="submit" id="valider_{{$f->id}}" class="valider" data-id="{{$f->id}}">V</button></td></form>
        
                <form method="post" action="" id="form3" class="frefuse"> <td>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$f->id}}">

                <input type="hidden" name="idfiche" value="{{$f->idfiche}}">
                <button type="submit" id="refuser_{{$f->id}}" class="refuser" data-id="{{$f->id}}">R</button></td></form>
            @php
            $F = $F + $f->heuresEffectu;
            $P = $P + $f->Poids;
            @endphp
        </tr>

        @if($loop->iteration==7)
        @foreach($sem1 as $s1)
        @php
        $se1 = $se1 + $s1->nombreH
        @endphp
        @endforeach
        <tr id="depass"><td colspan="2">Depassement autorisé : {{$se1}}
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
        @elseif($loop->iteration==14)
        @foreach($sem2 as $s2)
        @php
        $se2 = $se2 + $s2->nombreH
        @endphp
        @endforeach
        <tr id="depass"><td colspan="2">Depassement autorisé : {{$se2}}
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
        @elseif($loop->iteration==21)
                @foreach($sem3 as $s3)
                @php
                $se3 = $se3 + $s3->nombreH
                @endphp
                @endforeach
                <tr id="depass"><td colspan="2">Depassement autorisé : {{$se3}}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endif
    @if($loop->iteration == 21)
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
            <th></th>
            <th></th>
        </thead>
    <tbody>
    @foreach($fiche as $f)
    @if($loop->iteration >= 22)
    @if( $f->typeJour =="Travaillé")
    @php 
    $T=$T+1 
    @endphp
    @elseif( $f->typeJour =="Férié")
    @php 
    $FER=$FER+1 
    @endphp
    @elseif( $f->typeJour =="CP")
    @php 
    $CP=$CP+1 
    @endphp
    @elseif( $f->typeJour =="RTT")
    @php 
    $RTT=$RTT+1 
    @endphp
    @elseif( $f->typeJour =="1/2 RTT")
    @php 
    $HRTT=$HRTT+1 
    @endphp
    @elseif( $f->typeJour =="RCR")
    @php 
    $RCR=$RCR+1 
    @endphp
    @elseif( $f->typeJour =="Formation")
    @php 
    $FORMATION=$FORMATION+1 
    @endphp
    @elseif( $f->typeJour =="Maladie")
    @php 
    $MALADIE=$MALADIE+1 
    @endphp
    @elseif( $f->typeJour =="Congés familiaux")
    @php 
    $CF=$CF+1 
    @endphp
    @elseif( $f->typeJour =="Sans soldes")
    @php 
    $SS=$SS+1 
    @endphp
    @elseif( $f->typeJour =="Jour solidarité")
    @php 
    $JS=$JS+1 
    @endphp
    @endif
    <tr>
            <td>{{ $f->Date }}</td>
            <td>{{ $f->typeJour }}</td>
            <td>{{ $f->heuresEffectu }}</td>
            <td>{{ $f->Poids }}</td>
            <td>{{ $f->ecart }}</td>
            <form method="post" action="" id="form2" class="fconfirm"> <td>
                {{ csrf_field() }}
                 <input type="hidden" name="id" value="{{$f->id}}">
                 <input type="hidden" name="idfiche" value="{{$f->idfiche}}">

                <button type="submit" id="valider_{{$f->id}}" class="valider" data-id="{{$f->id}}">V</button></td></form>
        
                <form method="post" action="" id="form3" class="frefuse"> <td>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$f->id}}">

                <input type="hidden" name="idfiche" value="{{$f->idfiche}}">
                <button type="submit" id="refuser_{{$f->id}}" class="refuser" data-id="{{$f->id}}">R</button></td></form>
            @php
            $F = $F + $f->heuresEffectu;
            $P = $P + $f->Poids;
            @endphp
        </tr>
        @if($loop->iteration==28)
        @foreach($sem4 as $s4)
        @php
        $se4 = $se4 + $s4->nombreH
        @endphp
        @endforeach
        <tr id="depass"><td colspan="2">Depassement autorisé : {{$se4}}
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
@elseif($loop->last)
                @foreach($sem5 as $s5)
                @php
                $se5 = $se5 + $s5->nombreH
                @endphp
                @endforeach
                <tr id="depass"><td colspan="2">Depassement autorisé : {{$se5}}
            </td>
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
               <td id="Fer">{{$FER}}.00</td>
               <td id="typeStat">Férié (jour)</td>
           </tr>
           <tr id="trT">
               <td id="tra">{{$T}}.00</td>
               <td id="typeStat">Travaillé (jour)</td>
           </tr>
           <tr id="trT">
               <td id="cp">{{$CP}}.00</td>
               <td id="typeStat">CP (jour)</td>
           </tr>
           <tr id="trT">
               <td id="RTT">{{$RTT}}.00</td>
               <td id="typeStat">RTT (jour)</td>
           </tr>
           <tr>
               <td id="HRTT">{{$HRTT}}.00</td>
               <td id="typeStat">1/2 RTT (jour)</td>
           </tr>
           <tr id="trT">
               <td id="RCR">{{$RCR}}.00</td>
               <td id="typeStat">RCR (jour)</td>
           </tr>
           <tr id="trT">
               <td id="forma">{{$FORMATION}}.00</td>
               <td id="typeStat">Fomation (jour)</td>
           </tr>
           <tr id="trT">
               <td id="malad">{{$MALADIE}}.00</td>
               <td id="typeStat">Maladie (jour)</td>
           </tr>
           <tr id="trT">
               <td id="CF">{{$CF}}.00</td>
               <td id="typeStat">Congés familiaux (jour)</td>
           </tr>
           <tr id="trT">
               <td id="SS">{{$SS}}.00</td>
               <td id="typeStat">Sans soldes (jour)</td>
           </tr>
           <tr id="trT">
               <td id="js">{{$JS}}.00</td>
               <td id="typeStat">Jour solidarité</td>
           </tr>
       </table>
    </div>
    <div id="controle">
        <table id="tableControle">
            <thead>
                <th colspan="2" style="text-align: center;">CONTROLE</th>
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
                @php
                $DEP=$se1+$se2+$se3+$se4+$se5;
                @endphp
                <tr id="trContr" style="background-color:white;">
                    <td style="PADDING: 5 2 5 10;"><b>Dépassement autorisé :</b></td>
                    <td style="padding: 1 9 1 10;">{{$DEP}}</td>
                </tr>

                </tr>
            </tbody>
        </table>
    </div>
        </div>

<script>
$("#form2").on("submit", function (e) {
    var dataString = $(this).serialize();
    let id = $(this).data('id');
    let idfiche = $(this).data('idfiche');
    $.ajax({
      type: "POST",
      url: "/FicheHoraire/Details/confirm/"+id+"/"+idfiche,
      data: dataString,
      success: function () {
      }
    });
    e.preventDefault();
});
</script>
<script>
$("#form3").on("submit", function (e) {
    var dataString = $(this).serialize();
    let id = $(this).data('id');
    let idfiche = $(this).data('idfiche');
    $.ajax({
      type: "POST",
      url: "/FicheHoraire/Details/refuse/"+id+"/"+idfiche,
      data: dataString,
      success: function () {
      }
    });
    e.preventDefault();
});
</script>
<script>
    $(".valider").click(function() {
        //get current id which was clicked
        var current_id = $(this).data("id");
        if ($('#refuser_'+current_id).prop("disabled")) {
            $('#refuser_'+current_id).attr("disabled", false);
        } else {
            $('#refuser_'+current_id).attr("disabled", true);
        }
        $("#form2").toggle();
    });
    $(".refuser").click(function() {
        //get current id which was clicked
        var current_id = $(this).data("id");
        if ($('#valider_'+current_id).prop("disabled")) {
            $('#valider_'+current_id).attr("disabled", false);
        } else {
            $('#valider_'+current_id).attr("disabled", true);
        }
        $("#form3").toggle();
    });
</script>

  @endsection

