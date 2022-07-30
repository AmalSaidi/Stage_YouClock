@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/activites.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>activités</title>

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
<p id="fa-titre" style="font-family: cursive;">Familles de la Sarthe - Liste des activités</p>
<br>
<div id="button-list">
<form id="form2" action="{{ route('activites.details') }}" method="POST">
{{ csrf_field() }}
<button id="export"> Export CSV <img id="logo-reglages" src="/images/downald.png" alt="reglages">
</button>

</form><button id="ajouter"> ajouter une activité
</button>

</div>    

        <table class="table-bordered">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">Code</th>
      <th scope="col">Libellé</th>
      <th scope="col">Poids</th>
      <th scope="col" id="hidden"></th>
    </tr>
  </thead>
  <tbody>
  @foreach( $activites as $acti )

  <tr>
      <td>{{ $acti->code }}</td>
      <td>{{ $acti->libellé }}</td>
      <td>{{ $acti->Poids }}</td>
      <td id="hidden-cases"> <div id="logo1">
      <a href = 'activites/edit/{{ $acti->id }}'><button id="mod">
      <img id="logo-reglages" src="https://cdn.discordapp.com/attachments/936584358654005321/973487539618971648/reglages.png" alt="reglages"></button></a>
  </div></td>
    </tr>
    @endforeach
  </tbody>
</table>

<div>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="/activites" method="POST">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="code">Code</label>
    <input type="text" class="form-control" name="code" id="code" placeholder="Entrez le code de l'activité">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Libellé</label>
    <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Entrez le libellé de l'activité">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"> Poids</label>
    <input type="text" class="form-control" name="poids" id="poids" placeholder="Entrez le poids de l'activité">
  </div>
  <button type="submit" class="btn btn-primary" id="ajouter-button">AJOUTER</button>
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
<script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
<script>
$("#form2").on("submit", function (e) {
    var dataString = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "activites",
      data: dataString,
      success: function () {
      }
    });
    e.preventDefault();
});
</script>
@endsection
  