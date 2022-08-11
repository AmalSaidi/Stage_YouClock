
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/stat.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Statistiques</title>

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
        <form method="post" action="" type="get" > <td>
                {{ csrf_field() }}
        <select name="searchstat" onchange="this.form.submit()" style="float:right;">
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
    <button id="ventilation"><a href ='/ventilation/{{ $employe->id }}'>Ventilation</a></button>
    <button id="stat"><a href="/statistiques/{{ $employe->id }}" style="color:white;">Statistiques</a></button>
    @endforeach
</div>
    <table class="table-bordered" id="fiches1">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col" colspan="2">Ventilation analytique</th>
    </tr>
  </thead>
  <tbody>
  <tr>
        <td>FRASAD</td>
        <td id="secondCol">{{$FRASAD}}</td>
    </tr>
    <tr>
        <td>Fédération</td>
        <td id="secondCol">{{$Fédération}}</td>
    </tr>
    <tr>
        <td>Prestataire</td>
        <td id="secondCol">{{$Prestataire}}</td>
    </tr>
    <tr>
        <td>Voisineurs</td>
        <td id="secondCol">{{$Voisineurs}}</td>
    </tr>
    <tr>
        <td>ADU services</td>
        <td id="secondCol">{{$ADU}}</td>
    </tr>
    <tr>
        <td>Mandataires</td>
        <td id="secondCol">{{$Mandataires}}</td>
    </tr>
    <tr>
        <td>SOS Garde d'enfants</td>
        <td id="secondCol">{{$SOS}}</td>
    </tr>
    <tr>
        <td>ADVM</td>
        <td id="secondCol">{{$ADVM}}</td>
    </tr>
    <tr>
        <td>Délégation</td>
        <td id="secondCol">{{$Délégation}}</td>
    </tr>
    <tr>
        <td>AI</td>
        <td id="secondCol">{{$AI}}</td>
    </tr>
  </tbody>
    </table>
    <table class="table-bordered" id="fiches2">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col" id="hidden"></th>
      <th scope="col" id="hidden"></th>
      <th scope="col">Jan</th>
      <th scope="col">Fév</th>
      <th scope="col">Mar</th>
      <th scope="col">Avr</th>
      <th scope="col">Mai</th>
      <th scope="col">Juin</th>
      <th scope="col">Juill</th>
      <th scope="col">Août</th>
      <th scope="col">Sep</th>
      <th scope="col">Oct</th>
      <th scope="col">Nov</th>
      <th scope="col">Déc</th>
    </tr>
  </thead>
  <tbody>
  <tr>
  <td id="secCol"><div id="fer">{{$ferie}}.00</div></td>
        <td id="firstCol">Férié (jour)</td>
        <td style="WIDTH: 70;">{{$FerieJan}}</td>
        <td style="WIDTH: 70;">{{$FerieFev}}</td>
        <td style="WIDTH: 70;">{{$FerieMar}}</td>
        <td style="WIDTH: 70;">{{$FerieAvr}}</td>
        <td style="WIDTH: 70;">{{$FerieMai}}</td>
        <td style="WIDTH: 70;">{{$FerieJuin}}</td>
        <td style="WIDTH: 70;">{{$FerieJuillet}}</td>
        <td style="WIDTH: 70;">{{$FerieAout}}</td>
        <td style="WIDTH: 70;">{{$FerieSeptembre}}</td>
        <td style="WIDTH: 70;">{{$FerieOctobre}}</td>
        <td style="WIDTH: 70;">{{$FerieNovembre}}</td>
        <td style="WIDTH: 70;">{{$FerieDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="tra">{{$TR}}.00</div></td>
    <td id="firstCol">Travaillé (jour)</td>
        <td>{{$TRJan}}</td>
        <td>{{$TRFev}}</td>
        <td>{{$TRMar}}</td>
        <td>{{$TRAvr}}</td>
        <td>{{$TRMai}}</td>
        <td>{{$TRJuin}}</td>
        <td>{{$TRJuillet}}</td>
        <td>{{$TRAout}}</td>
        <td>{{$TRSeptembre}}</td>
        <td>{{$TROctobre}}</td>
        <td>{{$TRNovembre}}</td>
        <td>{{$TRDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="cp">{{$CP}}.00</div></td>
    <td id="firstCol">CP (jour)</td>
        <td>{{$CPJan}}</td>
        <td>{{$CPFev}}</td>
        <td>{{$CPMar}}</td>
        <td>{{$CPAvr}}</td>
        <td>{{$CPMai}}</td>
        <td>{{$CPJuin}}</td>
        <td>{{$CPJuillet}}</td>
        <td>{{$CPAout}}</td>
        <td>{{$CPSeptembre}}</td>
        <td>{{$CPOctobre}}</td>
        <td>{{$CPNovembre}}</td>
        <td>{{$CPDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="RTT">{{$RTT}}.00</div></td>
    <td id="firstCol">RTT (jour)</td>
        <td>{{$RTTJan}}</td>
        <td>{{$RTTFev}}</td>
        <td>{{$RTTMar}}</td>
        <td>{{$RTTAvr}}</td>
        <td>{{$RTTMai}}</td>
        <td>{{$RTTJuin}}</td>
        <td>{{$RTTJuillet}}</td>
        <td>{{$RTTAout}}</td>
        <td>{{$RTTSeptembre}}</td>
        <td>{{$RTTOctobre}}</td>
        <td>{{$RTTNovembre}}</td>
        <td>{{$RTTDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="HRTT">{{$HRTT}}.00</div></td>
    <td id="firstCol">1/2 RTT (jour)</td>
        <td>{{$HRTTJan}}</td>
        <td>{{$HRTTFev}}</td>
        <td>{{$HRTTMar}}</td>
        <td>{{$HRTTAvr}}</td>
        <td>{{$HRTTMai}}</td>
        <td>{{$HRTTJuin}}</td>
        <td>{{$HRTTJuillet}}</td>
        <td>{{$HRTTAout}}</td>
        <td>{{$HRTTSeptembre}}</td>
        <td>{{$HRTTOctobre}}</td>
        <td>{{$HRTTNovembre}}</td>
        <td>{{$HRTTDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="RCR">{{$RCR}}.00</div></td>
    <td id="firstCol">RCR (jour)</td>
        <td>{{$RCRJan}}</td>
        <td>{{$RCRFev}}</td>
        <td>{{$RCRMar}}</td>
        <td>{{$RCRAvr}}</td>
        <td>{{$RCRMai}}</td>
        <td>{{$RCRJuin}}</td>
        <td>{{$RCRJuillet}}</td>
        <td>{{$RCRAout}}</td>
        <td>{{$RCRSeptembre}}</td>
        <td>{{$RCROctobre}}</td>
        <td>{{$RCRNovembre}}</td>
        <td>{{$RCRDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="forma">{{$FOR}}.00</div></td>
    <td id="firstCol">Fomation (jour)</td>
        <td>{{$FORJan}}</td>
        <td>{{$FORFev}}</td>
        <td>{{$FORMar}}</td>
        <td>{{$FORAvr}}</td>
        <td>{{$FORMai}}</td>
        <td>{{$FORJuin}}</td>
        <td>{{$FORJuillet}}</td>
        <td>{{$FORAout}}</td>
        <td>{{$FORSeptembre}}</td>
        <td>{{$FOROctobre}}</td>
        <td>{{$FORNovembre}}</td>
        <td>{{$FORDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="malad">{{$MAL}}.00</div></td>
    <td id="firstCol">Maladie (jour)</td>
        <td>{{$MALJan}}</td>
        <td>{{$MALFev}}</td>
        <td>{{$MALMar}}</td>
        <td>{{$MALAvr}}</td>
        <td>{{$MALMai}}</td>
        <td>{{$MALJuin}}</td>
        <td>{{$MALJuillet}}</td>
        <td>{{$MALAout}}</td>
        <td>{{$MALSeptembre}}</td>
        <td>{{$MALOctobre}}</td>
        <td>{{$MALNovembre}}</td>
        <td>{{$MALDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="CF">{{$CF}}.00</div></td>
    <td id="firstCol">Congés familiaux (jour)</td>
        <td>{{$CFJan}}</td>
        <td>{{$CFFev}}</td>
        <td>{{$CFMar}}</td>
        <td>{{$CFAvr}}</td>
        <td>{{$CFMai}}</td>
        <td>{{$CFJuin}}</td>
        <td>{{$CFJuillet}}</td>
        <td>{{$CFAout}}</td>
        <td>{{$CFSeptembre}}</td>
        <td>{{$CFOctobre}}</td>
        <td>{{$CFNovembre}}</td>
        <td>{{$CFDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="SS">{{$SS}}.00</div></td>
    <td id="firstCol">Sans soldes (jour)</td>
        <td>{{$SSJan}}</td>
        <td>{{$SSFev}}</td>
        <td>{{$SSMar}}</td>
        <td>{{$SSAvr}}</td>
        <td>{{$SSMai}}</td>
        <td>{{$SSJuin}}</td>
        <td>{{$SSJuillet}}</td>
        <td>{{$SSAout}}</td>
        <td>{{$SSSeptembre}}</td>
        <td>{{$SSOctobre}}</td>
        <td>{{$SSNovembre}}</td>
        <td>{{$SSDecembre}}</td>
    </tr>
    <tr>
    <td id="secCol"><div id="js">{{$JS}}.00</div></td>
    <td id="firstCol">Jour solidarité</td>
        <td>{{$JSJan}}</td>
        <td>{{$JSFev}}</td>
        <td>{{$JSMar}}</td>
        <td>{{$JSAvr}}</td>
        <td>{{$JSMai}}</td>
        <td>{{$JSJuin}}</td>
        <td>{{$JSJuillet}}</td>
        <td>{{$JSAout}}</td>
        <td>{{$JSSeptembre}}</td>
        <td>{{$JSOctobre}}</td>
        <td>{{$JSNovembre}}</td>
        <td>{{$JSDecembre}}</td>
    </tr>
    <tr id="extraRow">
    <td id="extraRow" colspan="2"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
        <td id="extraRow"></td>
    </tr>
    <tr>
    <tr>
    <td id="firstCol" colspan="2">Temps de dépassement réalisé</td>
        <td>{{$DJan}}</td>
        <td>{{$DFev}}</td>
        <td>{{$DMar}}</td>
        <td>{{$DAvr}}</td>
        <td>{{$DMai}}</td>
        <td>{{$DJuin}}</td>
        <td>{{$DJuil}}</td>
        <td>{{$DAout}}</td>
        <td>{{$DSept}}</td>
        <td>{{$DOct}}</td>
        <td>{{$DNov}}</td>
        <td>{{$DDec}}</td>
    </tr>
    <tr>
    <td id="firstCol" colspan="2">Temps à récupérer - soldes</td>
    @if($EJan>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EJan}}</td>
    @endif
    @if($EFev>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EFev}}</td>
    @endif
    @if($EMar>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EMar}}</td>
    @endif
    @if($EAvr>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EAvr}}</td>
    @endif
    @if($EMai>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EMai}}</td>
    @endif
    @if($EJuin>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EJuin}}</td>
    @endif
    @if($EJuil>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EJuil}}</td>
    @endif
    @if($EAout>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EAout}}</td>
    @endif
    @if($ESept>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$ESept}}</td>
    @endif
    @if($EOct>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EOct}}</td>
    @endif
    @if($ENov>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$ENov}}</td>
    @endif
    @if($EDec>=0)
    <td>0</td>
    @else
    <td style="background-color:#f94545;">{{$EDec}}</td>
    @endif
    </tr>
  </tbody>
    </table>
    <div id="controle">
    </div>



  @endsection
