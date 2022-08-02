@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/PageEmployes.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Employés</title>

@section('content')
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
<div id="acti">
@if(Auth::user()->admin==1 AND Auth::user()->direction==1)
<div id="vue" style="text-align-last: right;">
<form method="post" action="/employes/direction" id="form3" class="direction" style="float: left;"> <td>
                {{ csrf_field() }}
                
      <button type="submit" class="btn btn-primary" id="vuebutton"> Vue direction</button>
</form>
<form method="post" action="/employes/admin" id="form4" class="admin"> <td>
                {{ csrf_field() }}
      <button type="submit" class="btn btn-primary" id="vuebutton"> Vue admin</button>
</form>
</div>
      @endif
        <br>  

        <table class="table-borderless">
        <thead class="thead">
    <tr id="head-table">

      <th scope="col">Employés</th>
      <th scope="col">Structure</th>
      <th scope="col">Date de début</th>
      <th scope="col">Date de fin</th>
      <th scope="col">Contrat Mensuel</th>
      <th scope="col">Adresse mail</th>
    </tr>
  </thead>
  <tbody>
  @foreach( $employees as $employe )
     
<tr>
      <td><a id="link-nom" href = '/employes/{{ $employe->id }}'><img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/1002995429509697547/icons8-utilisateur-48_1.png">{{ $employe->nom }} {{ $employe->prenom }}</a></td>
      <td><div id="stru">{{ $employe->structure }}</div></td>
      <td>{{ $employe->dateEmbauche }}</td>
      <td>{{ $employe->Datefin }}</td>
      <td>{{ $employe->TypeContrat }}</td>
      <td>{{ $employe->mail }}</td>
    
</tr>
@endforeach          

  </tbody>
</table>
<div id="myModal" class="modal" style="overflow: auto;">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="/employes" method="POST">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="code">Nom</label>
    <input type="text" class="form-control" name="nom" id="code" placeholder="Nom de l'employé" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Prénom</label>
    <input type="text" class="form-control" name="prenom" id="libelle" placeholder="Prénom de l'employé"  required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">identifiant</label>
    <input type="text" class="form-control" name="identifiant" id="identifiant" placeholder="identifiant de l'employé " required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Structure</label>
    <br>
    <select name="structure" id="struSelect"  required>
      @foreach($structures as $str)
      <option>{{ $str->libellé}} </option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Service</label>
    <br>
    <select name="service" id="struSelect"  required>
      @foreach($services as $ser)
      <option>{{ $ser->libellé}} </option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">type</label>
    <br>
    <select name="type" id="type"  required>
      <option>admin</option>
      <option>direction</option>
      <option>utilisateur</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Intitulé</label>
    <input type="text" class="form-control" name="intitule" id="libelle" placeholder="intitulé de l'employé"  required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Date de début</label>
    <input type="date" class="form-control" name="dateEmbauche" id="poids" placeholder="La date de début"  required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Date de fin</label>
    <input type="date" class="form-control" name="Datefin" id="poids" placeholder="La date de fin"  required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contrat mensuel</label>
    <input type="text" class="form-control" name="TypeContrat" id="poids" placeholder="Le contrat mensuel"  required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Adresse mail</label>
    <input type="email" class="form-control" name="mail" id="poids" placeholder="L'adresse mail"  required>
  </div>

  <button type="submit" class="btn btn-primary" id="ajouter-button">AJOUTER</button>
</form>
  </div>

</div>

    </div>
    <script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
    </script>
<script>
$("#form3").on("submit", function (e) {
    $.ajax({
      type: "POST",
      url: "/employes/direction";
      data: dataString,
      success: function () {
      }
    });
    e.preventDefault();
});
</script>
<script>
$("#form4").on("submit", function (e) {
    $.ajax({
      type: "POST",
      url: "/employes/admin";
      data: dataString,
      success: function () {
      }
    });
    e.preventDefault();
});
</script>
@endsection
  