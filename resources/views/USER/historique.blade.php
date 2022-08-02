@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/histo.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<title>historique</title>

<style>
    #menu-reg {
    BACKGROUND-COLOR: WHITE;
    WIDTH: 19%;
    margin-left: 2%;
    margin-top: 1.7%;
    padding-bottom: 80;
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
@foreach($employes as $emp)
    <div id="menu-reg">
    <img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/1002996904004694057/icons8-utilisateur-96_1.png">
    <BR>
    <div id="info-user"><p>{{ $emp->nom }} {{ $emp->prenom }}</p></div>
<div id="stru-user">{{ $emp->structure }}</div>
<div><button class="btn btn-danger" style="margin-top: 20;"id="ajouter"> ajouter une fiche </div>
</button>
</div>
@endforeach
<div id="acti">
@if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
@endif
<h3>Historique</h3>
<table class="table-bordered">
<tbody>
    <th>Date</th>
    <th>Statut</th>
</tbody>
@foreach($fiiche as $f)
<tr>
    <td id="DateF"><a id="link-nom" href = '/historiqueDetails/{{ $f->idfiche }}'>{{ $f->idfiche }}</a></td>
    @if($f->statutF=="EnCours")
  <td><div id="encours">EN COURS</div></td>
  @elseif($f->statutF=="AttValiRS")
  <td><div id="enAttRS">EN ATTENTE VALIDATION RESPONSABLE SERVICE </div></td>
  @elseif($f->statutF=="valideRS")
  <td><div id="valideRS"> VALIDÉ PAR RESPONSABLE DE SERVICE</div></td>
  @else
  <td><div id="valide">VALIDÉ</div></td>
  @endif
</tr>
@endforeach
</table>

</div>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" style="margin-top: 8%;">
    <span class="close">&times;</span>
    <form action="" method="POST">
    {{ csrf_field() }}
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
  <button type="submit" class="btn btn-primary" id="add">AJOUTER</button>
</form>
  </div>

</div>
<script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
       <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
@endsection
  