

@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/depHor.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />

@section('content')
    <div id="button-list">
<div class="input-group mb-3">
  <div class="form-outline">
    <input type="search" id="form1" class="form-control" placeholder="Rechercher" />
  </div>
</div>
</div>  
<div id="menu-reg">
<table class="table-borderless">
  <tbody>
  @foreach( $employes as $emp )
    <tr>
      <td><a id="link-nom" href = '/employes/{{ $emp->id }}'>{{ $emp->nom }} {{ $emp->prenom }} </a><br>
        <small>{{ $emp->structure }}</small>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

    <div id="acti">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <h3>Autorisation dépassement horaire</h3>
    <div id="form-dep">
        <table style=" width: 60% !important;">
          <form action="/depassementHoraire" method="POST">
          {{ csrf_field() }}
            <tr><td>Nom du salarié</td><td><select name="nom">
              @foreach($emplo as $emp)
              <option value="{{ $emp->identifiant }}">{{ $emp->fullname }}</option>
              @endforeach
            </select></td></tr>
          <tr><td>Numéro de la semaine</td><td><select name="semaine">
            <option>semaine 1</option>
            <option>semaine 2</option>
            <option>semaine 3</option>
            <option>semaine 4</option>
            <option>semaine 5</option>
        </select></td></tr>
        <tr><td>mois</td><td><select name="mois">
        <option>Janvier</option>
            <option>Février</option>
            <option>Mars</option>
            <option>Avril</option>
            <option>Mai</option>
            <option>Juin</option>
            <option>Juillet</option>
            <option>Août</option>
            <option>Septembre</option>
            <option>Octobre</option>
            <option>Novembre</option>
            <option>Décembre</option>
        </select></td></tr>
        @php
        $year=date("Y");
        @endphp
        <tr><td>Année</td><td><input name="year" type="number" min="1900" max="2099" step="1" value="{{$year}}" /></td></tr>
            <tr><td id="textarea">Motif</td>
            <td><textarea name="motif"></textarea></td></tr>
            <tr><td>Nombre d'heures</td>
            <td><input name="heures" type="number" placeholder="" step="0.1" min="0" max="10"/></td></tr>
            <tr><td></td><td><button id="valider">Valider le dépassement horaire</button></td></tr>
            </form>

        </table>
        </div>
    
     <script>
      function openForm() {
      document.getElementById("modal").style.display = "block";
      }
      function closeForm() {
      document.getElementById("modal").style.display = "none";
      }
    </script>
  
  @endsection