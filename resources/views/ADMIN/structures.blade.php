@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/structures.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Structures</title>

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
        <p id="fa-titre" style="font-family: cursive;">Familles de la Sarthe - Liste des structures</p>
        <br>
<div id="button-list">
<form id="form2" action="{{ route('structures.details') }}" method="POST">
{{ csrf_field() }}
<button id="export"> Export CSV <img id="logo-reglages" src="/images/downald.png" alt="reglages">
</button>
</form>
<button id="ajouter"> ajouter une structure
</button>
</div>    

        <table class="table-bordered">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col" id="lib">Libellé de la structure</th>
      <th scope="col">Code</th>
      <th scope="col">Congé payé</th>
      <th scope="col" id="hidden"></th>
    </tr>
  </thead>
  <tbody>
  @foreach( $structures as $structure )

  <tr>
      <td id="lib">{{ $structure->libellé }}</td>
      <td>{{ $structure->code }}</td>
      <td>{{ $structure->congePaye }}</td>
      <td id="hidden-cases"> <div id="logo1">
      <a href = 'structures/edit/{{ $structure->id }}'><button id="mod">
      <img id="logo-reglages" src="https://cdn.discordapp.com/attachments/936584358654005321/973487539618971648/reglages.png" alt="reglages"></button></a>
  </div></td>
    </tr>
    @endforeach
    </tbody>
</table>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="/structures" method="POST">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="code">Libellé</label>
    <input type="text" class="form-control"  name="libelle" id="code" placeholder="Entrez le libellé du service">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Code</label>
    <input type="text" class="form-control"  name="code" id="libelle" placeholder="Entrez le nom du responsable du service">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Congé Payé</label>
    <input type="text" class="form-control"  name="congePaye" id="libelle" placeholder="Entrez le nom du responsable du service">
  </div>
  <button type="submit" class="btn btn-primary" id="ajouter-button">AJOUTER</button>
</form>
  </div>
</div>

  <!-- form de modification -->
  <div class="modal" id="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close" onclick="closeForm(modal);">&times;</span>
  <form>
<div class="form-group">
  <label for="code">Libellé de la service</label>
  <input type="text" class="form-control" id="lib" placeholder="le libellé de la service">
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Responsable de service</label>
  <input type="text" class="form-control" id="code" placeholder="Reponsable de la service">
</div>
<button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
</div>
<script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>
<script>
$("#form2").on("submit", function (e) {
    var dataString = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "structures",
      data: dataString,
      success: function () {
      }
    });
    e.preventDefault();
});
</script>
  </div>
@endsection
  