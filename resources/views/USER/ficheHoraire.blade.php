@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<script>
  
</script>
@section('content')
@php
$userNom=Auth::user()->name;
$userId=Auth::user()->id;
@endphp
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
      <td>Total des heures effectués : </td>
    </tr>
    <tr>
      <td>Total des heures à effectuer :</td>
    </tr>
    <tr>
      <td>Ecart :</td>
    </tr>
  </tbody>
</table>
</div>
@endif
@endforeach
<div id="acti">
<h3>Fiche Horaires</h3>
<br>
<div id="button-list">
<button id="ajouter">Pointer
</button>
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
  @php
    @endphp
    @for($i=1;$i <= $dateF; $i++)
    @php
      $date = date("Y-m-$i", strtotime("+1 day", strtotime($date)));
      $day_name = date('l', strtotime($date));
      $day_num = date('d', strtotime($date));
      $year_num = date('Y', strtotime($date));
    @endphp
    @if($day_name=="Wednesday")
    @php
    $day_name="Mer"
    @endphp
    @elseif($day_name=="Thursday")
    @php
    $day_name="Jeu"
    @endphp
    @elseif($day_name=="Friday")
    @php
    $day_name="Ven"
    @endphp
    @elseif($day_name=="Saturday")
    @php
    $day_name="Sam"
    @endphp
    @elseif($day_name=="Sunday")
    @php
    $day_name="Dim"
    @endphp
    @elseif($day_name=="Monday")
    @php
    $day_name="Lun"
    @endphp
    @elseif($day_name=="Tuesday")
    @php
    $day_name="Mar"
    @endphp
    @endif
    @foreach( $employes as $employe )
    @if($employe->nom==$userNom)
      <tr>
      <form action="/FicheHoraire" method="POST">
      {{ csrf_field() }}
      <td><input name="date" type="hidden" value="{{ $day_name }} {{ $day_num}} {{ $month }}"> {{ $day_name }} {{ $day_num}} {{ $month }}</input></td>
      @if($day_name=="Lun")
      @foreach( $lundi as $lundii )
      @php
      $hourdiffMat = round((strtotime($lundii->FinMat) - strtotime($lundii->DebutMat))/3600, 1);
      $hourdiffAprem = round((strtotime($lundii->FinAprem) - strtotime($lundii->DebutAprem))/3600, 1);
      $hourdone= $hourdiffMat + $hourdiffAprem;
      @endphp
        <input name="idfiche" type="hidden" value="{{ $year_num }} - {{$month}}"></input>
        <input name="idUser" type="hidden" value="{{ $userId }}"></input>
        <td><input name="typeM" type="hidden" value="{{$lundii->typeM}}">{{$lundii->typeM}}</input></td>
        <td><input name="matin" type="hidden" value ="{{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->FinMat)->format('H:i')}}">{{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->FinMat)->format('H:i')}} </input></td>
        <td><input name="typeAP" type="hidden" value="{{$lundii->typeAP}}">{{$lundii->typeAP}}</input></td>
        <td><input name="aprem" type="hidden" value="{{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->FinAprem)->format('H:i')}}">{{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$lundii->FinAprem)->format('H:i')}}</input></td>
        <td><input name="typeS" type="hidden" value="{{$lundii->typeS}}">{{$lundii->typeS}}</input></td>
        <td><input name="soir" type="hidden"></input></td>
        <td><input name="heuresEffec" type="hidden">7</input></td>
        <td><input name="poids" type="hidden" value="{{ $hourdone }}">{{ $hourdone }}</input></td>
        <td><input name="ecartJour" type="hidden"></input></td>
        <td><button type="submit">>Pointer</button></td>
      </form>
        @endforeach
        @elseif($day_name=="Mar")
      @foreach( $mardi as $mardii )
      @php
      $hourdiffMat = round((strtotime($mardii->FinMat) - strtotime($mardii->DebutMat))/3600, 1);
      $hourdiffAprem = round((strtotime($mardii->FinAprem) - strtotime($mardii->DebutAprem))/3600, 1);
      $hourdone= $hourdiffMat + $hourdiffAprem;
      @endphp
        <td><input type="hidden">{{$mardii->typeM}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$mardii->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$mardii->FinMat)->format('H:i')}} </input></td>
        <td><input type="hidden">{{$mardii->typeAP}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$mardii->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$mardii->FinAprem)->format('H:i')}}</input></td>
        <td><input type="hidden">{{$mardii->typeS}}</input></td>
        <td></td>
        <td>7</td>
        <td><input type="hidden">{{ $hourdone }}</input></td>
        <td></td>
        <td><a href="">Pointer</a></td>
        @endforeach
        @elseif($day_name=="Mer")
      @foreach( $mercredi as $mer )
      @php
      $hourdiffMat = round((strtotime($mer->FinMat) - strtotime($mer->DebutMat))/3600, 1);
      $hourdiffAprem = round((strtotime($mer->FinAprem) - strtotime($mer->DebutAprem))/3600, 1);
      $hourdone= $hourdiffMat + $hourdiffAprem;
      $ecartJour = $hourdone;
      @endphp
        <td><input type="hidden">{{$mer->typeM}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$mer->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$mer->FinMat)->format('H:i')}} </input></td>
        <td><input type="hidden">{{$mer->typeAP}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$mer->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$mer->FinAprem)->format('H:i')}}</input></td>
        <td><input type="hidden">{{$mer->typeS}}</input></td>
        <td></td>
        <td>5</td>
        <td><input type="hidden">{{ $hourdone }}</input></td>
        <td></td>
        <td><a href="">Pointer</a></td>
        @endforeach
        @elseif($day_name=="Jeu")
      @foreach( $jeudi as $jeu )
      @php
      $hourdiffMat = round((strtotime($jeu->FinMat) - strtotime($jeu->DebutMat))/3600, 1);
      $hourdiffAprem = round((strtotime($jeu->FinAprem) - strtotime($jeu->DebutAprem))/3600, 1);
      $hourdone= $hourdiffMat + $hourdiffAprem;
      @endphp
        <td><input type="hidden">{{$jeu->typeM}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$jeu->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$jeu->FinMat)->format('H:i')}}</input> </td>
        <td><input type="hidden">{{$jeu->typeAP}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$jeu->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$jeu->FinAprem)->format('H:i')}}</input></td>
        <td><input type="hidden">{{$jeu->typeS}}</input></td>
        <td></td>
        <td>7</td>
        <td><input type="hidden">{{ $hourdone }}</input></td>
        <td></td>
        <td><a href="">Pointer</a></td>
        @endforeach
        @elseif($day_name=="Ven")
      @foreach( $vendredi as $ven )
      @php
      $hourdiffMat = round((strtotime($ven->FinMat) - strtotime($ven->DebutMat))/3600, 1);
      $hourdiffAprem = round((strtotime($ven->FinAprem) - strtotime($ven->DebutAprem))/3600, 1);
      $hourdone= $hourdiffMat + $hourdiffAprem;
      @endphp
        <td><input type="hidden">{{$ven->typeM}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$ven->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$ven->FinMat)->format('H:i')}}</input> </td>
        <td><input type="hidden">{{$ven->typeAP}}</input></td>
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$ven->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$ven->FinAprem)->format('H:i')}}</input></td>
        <td><input type="hidden">{{$ven->typeS}}</input></td>
        <td></td>
        <td>7</td>
        <td><input type="hidden">{{ $hourdone }}</input></td>
        <td></td>
        <td><a href="">Pointer</a></td>
        @endforeach
        @elseif($day_name=="Sam")
      @foreach( $samedi as $sam )
      @php
      $hourdiffMat = round((strtotime($sam->FinMat) - strtotime($sam->DebutMat))/3600, 1);
      $hourdiffAprem = round((strtotime($sam->FinAprem) - strtotime($sam->DebutAprem))/3600, 1);
      $hourdone= $hourdiffMat + $hourdiffAprem;
      @endphp
        <td><input type="hidden">{{$sam->typeM}}</input></td>
        @if($sam->DebutMat!=null)
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$sam->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$sam->FinMat)->format('H:i')}}</input> </td>
        @else
        <td><input type="hidden"></input></td>
        @endif
        <td><input type="hidden">{{$sam->typeAP}}</input></td>
        @if($sam->DebutAprem!=null)
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$sam->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$sam->FinAprem)->format('H:i')}}</input></td>
        @else
        <td><input type="hidden"></input></td>
        @endif
        <td><input type="hidden">{{$sam->typeS}}</input></td>
        <td></td>
        <td>7</td>
        <td><input type="hidden">{{ $hourdone }}</input></td>
        <td></td>
        <td><a href="">Pointer</a></td>
        @endforeach
        @elseif($day_name=="Dim")
        @foreach( $dimanche as $dim )
      @php
      $hourdiffMat = round((strtotime($dim->FinMat) - strtotime($dim->DebutMat))/3600, 1);
      $hourdiffAprem = round((strtotime($dim->FinAprem) - strtotime($dim->DebutAprem))/3600, 1);
      $hourdone= $hourdiffMat + $hourdiffAprem;
      @endphp
        <td><input type="hidden">{{$dim->typeM}}</input></td>
        @if($dim->DebutMat!=null)
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$dim->DebutMat)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$dim->FinMat)->format('H:i')}}</input> </td>
        @else
        <td><input type="hidden"></input></td>
        @endif
        <td><input type="hidden">{{$dim->typeAP}}</input></td>
        @if($dim->DebutAprem!=null)
        <td><input type="hidden">{{\Carbon\Carbon::createFromFormat('H:i:s',$dim->DebutAprem)->format('H:i')}} - {{\Carbon\Carbon::createFromFormat('H:i:s',$dim->FinAprem)->format('H:i')}}</input></td>
        @else
        <td><input type="hidden"></input></td>
        @endif
        <td><input type="hidden">{{$dim->typeS}}</input></td>
        <td></td>
        <td>7</td>
        <td><input type="hidden">{{ $hourdone }}</input></td>
        <td></td>
        <td><a href="">Pointer</a></td>
        @endforeach
        @endif
      </tr>
      @endif
      @endforeach
    @endfor
  </tbody>
</table>

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
    <script>

      </script>
      <script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
       <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
      </script>
@endsection
  