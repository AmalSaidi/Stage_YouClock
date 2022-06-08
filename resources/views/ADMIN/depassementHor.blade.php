

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
  @foreach( $EmpSer as $emp )
    <tr>
      <td>{{ $emp->nom }} {{ $emp->prenom }} <br>
        <small>{{ $emp->intitule }}</small>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

    <div id="acti">
    <h3>Autorisation dépassement horaire</h3>
    <div id="form-dep">
        <table style=" width: 50% !important;">
            <form>
            <tr><td>Nom du salarié</td><td><select> <option value="boo">salarié1</option></select></td></tr>
            <tr><td>Numéro de la semaine</td><td><select> <option value="boo">Semaine 22</option>
            <option value="boo">option2</option>
        </select></td></tr>
            <tr><td id="textarea">Motif</td><td><textarea></textarea></td></tr>
            <tr><td>Nombre d'heures</td><td><input type="time"/></td></tr>
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