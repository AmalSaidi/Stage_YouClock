

@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/reglages.css') }}" />
<title>Dépassement horaire</title>

@section('content')
    <div id="button-list">
<div class="input-group mb-3">
  <div class="form-outline">
  <form method="post" action="/search" type="get" > <td>
                {{ csrf_field() }}
        <input type="search" id="form1" name="search" class="form-control" placeholder="Rechercher" />
      </form>
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
@foreach($empl as $e)
    <h3>dépassements horaires de {{$e->nom}} {{$e->prenom}}</h3>
@endforeach
    <table class="table-bordered" style="width:100%;">
        <thead>
            <th>semaine</th>
            <th>Fiche</th>
            <th>Nombre d'heures</th>
            <th>Motif</th>
            <th></th>
        </thead>
        <tbody>
        @foreach($dep as $d)
            <tr>
<td>{{$d->semaine}}</td>
<td>{{$d->idFiche}}</td>
<td>{{$d->nombreH}}</td>
<td>{{$d->motif}}</td>
<td><a href = '/depassements/edit/{{$d->id}}'>consulter</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
     <script>
      function openForm() {
      document.getElementById("modal").style.display = "block";
      }
      function closeForm() {
      document.getElementById("modal").style.display = "none";
      }
    </script>
  
  @endsection