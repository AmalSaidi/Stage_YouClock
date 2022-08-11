

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
<form action = "/depassements/edit/<?php echo $dep[0]->id; ?>" method = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<div class="form-group">
  <label for="code">Semaine</label>
  <input type="text" class="form-control" name = 'semaine' id="code" value = '<?php echo$dep[0]->semaine; ?>'>
  <input type="hidden" class="form-control" name = 'id' id="code" value = '<?php echo$dep[0]->id; ?>'>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Nombre d'heures</label>
  <input type="number" step ="0.01" name = 'nombreH' class="form-control" id="libelle" value = '<?php echo$dep[0]->nombreH; ?>'>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Motif</label>
  <input type="text" name = 'motif' class="form-control" id="poids" value = '<?php echo$dep[0]->motif; ?>'>
</div>
<button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
    
     <script>
      function openForm() {
      document.getElementById("modal").style.display = "block";
      }
      function closeForm() {
      document.getElementById("modal").style.display = "none";
      }
    </script>
  
  @endsection