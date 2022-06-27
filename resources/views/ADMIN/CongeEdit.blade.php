
@extends('ADMIN.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/demandeConge.css') }}" />
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
  @foreach( $employees as $emp )
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
    <div class="card" id="card">
  <div class="card-header">
        @if($demande[0]->type == "Congé payé")
        demande de congé principal
        @else
        demande de congé
        @endif
  </div>
  <div class="card-body">
    <h5 class="card-title">
        @php
        echo $demande[0]->demandeur;
        echo " ";
        echo $demande[0]->demandeurPrenom;
        @endphp
    </h5>
    <p class="card-text"> 
        <p>Date de début : @php echo $demande[0]->dateDebut; @endphp</p>
        <p>Date de Fin : @php echo $demande[0]->dateFin; @endphp</p>
        Total = 
        @php
        function dateDiffInDays($date1, $date2) 
        {
            $diff = strtotime($date2) - strtotime($date1);
            return abs(round($diff / 86400));
        }
        $total= dateDiffInDays($demande[0]->dateDebut,$demande[0]->dateFin)
        @endphp
        @php
        echo "$total";
        echo " ";
        echo "jours";
        @endphp
    </p>
    <form action = "/mesConges/confirm/<?php echo $demande[0]->id; ?>" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <button type="submit" class="btn btn-success" id="confirmer">Confirmer</button>
    </form>
    <form action = "/mesConges/refuse/<?php echo $demande[0]->id; ?>" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <button type="submit" class="btn btn-danger" id="Refuser">Refuser</button>
    </form>
  </div>
</div>
    </div>
     <script>
      function openForm() {
      document.getElementById("modal").style.display = "block";
      }
      function closeForm() {
      document.getElementById("modal").style.display = "none";
      }
    </script>

    @if($demande[0]->statut == "EnCours")
    <script>
        var element = document.getElementById("card");
        element.style.backgroundColor = "lightblue";
    </script>
    @endif
  
  @endsection

