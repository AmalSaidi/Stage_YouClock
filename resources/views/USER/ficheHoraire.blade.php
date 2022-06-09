@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<script>
  
</script>
@section('content')
@php
$userNom=Auth::user()->name;
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
  </thead>
  <tbody>
  @php
    @endphp
    @for($i=1;$i < 8; $i++)
    @php
      $date = date("Y-m-$i", strtotime("+1 day", strtotime($date)));
      $day_name = date('l', strtotime($date));
      $day_num = date('d', strtotime($date));

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

    
      <tr>
      <td> {{ $day_name }} {{ $day_num}}  <td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
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
      <script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
       <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
      </script>
@endsection
  