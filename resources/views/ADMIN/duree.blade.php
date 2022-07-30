@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/dureePause.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Durée de pause</title>

@section('content')
<div id="menu-reg">
    <P id="reglages">Réglages</P>
    <ul class="nav flex-column">
    <li class="reg" >
        <a class="nav-link" href="/activites">ACTIVITES</a>
      </li>
      <li class="reg" >
        <a class="nav-link" href="/structures">STRUCTURES</a>
      </li>
      <li class="reg" >
        <a class="nav-link" href="/services">SERVICES</a>
      </li>
      <li class="reg">
        <a class="nav-link" href="/dureePause">DUREE DES PAUSES</a>
      </li>
    </ul>
  </div>
  <div id="acti">
        <p id="fa-titre" style="font-family: cursive;">Durée des pauses</p>
        <p>Temps min entre MATIN et APRRES-MIDI </p>
        
@foreach( $duree as $duree )
<div id="timediv">{{\Carbon\Carbon::createFromFormat('H:i:s',$duree->pause)->format('H:i')}}</div>
@endforeach
<a href = 'dureePause/edit/{{ $duree->id }}'><button id="modifier">MODIFIER</button></a>
<div id="button-list">
<button id="export"> Export CSV <img id="logo-reglages" src="https://cdn.discordapp.com/attachments/936584358654005321/973940327759085619/downald.png" alt="reglages">
</button>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onclick="closeForm2(myModal)">&times;</span>
    <form>
    <p>Entrez la nouvelle durée de la pause :
  <div class="form-group">
    <input type="text" class="form-control" id="heure" placeholder="00"  maxlength = "2">
    <input type="text" class="form-control" id="min" placeholder="45" maxlength = "2">
  </div>

  <button type="submit" class="btn btn-primary" id="modifier">MODIFIER</button>
</form>
  </div>

</div>
<script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>
    </div>

@endsection
  