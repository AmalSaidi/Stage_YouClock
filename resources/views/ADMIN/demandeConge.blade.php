

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
    <h3>Equipe : Comptabilié / Paie</h3>
    <table class="table-bordered" id="MyTable">
  <thead>
      <th></th>
      @while(strtotime($date) <= strtotime(date('Y-m') . '-' . date('t', strtotime($date))))
@php
$day_num = date('j', strtotime($date));//Day number
$month_num = date('m', strtotime($date));
$day_name = date('l', strtotime($date));
$year = date('y', strtotime($date));
$day_abrev = date('S', strtotime($date));
$day = "$day_num";  
$date = date("Y-m-d", strtotime($date));
$month = date('m');
@endphp
@php
    $col_count=1;
    @endphp
    @if($month_num == $month and $day_name=="Sunday" or $day_name=="Saturday")
    <th id="hehe" style="background-color:#ccc6c6;" onclick="showDay('{{ $day }}')">{{ $day }}</th>
    @else
    <th id="hehe" onclick="showDay('{{ $day }}')">{{ $day }}</th>
    @endif
     @php
      $row_count++; 
      $col_count++; 
      $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
     @endphp
  @endwhile

  </thead>
  <tbody>
@php
function dateDiffInDays($date1, $date2) 
  {
      // Calculating the difference in timestamps
      $diff = strtotime($date2) - strtotime($date1);
  
      // 1 day = 24 hours
      // 24 * 60 * 60 = 86400 seconds
      return abs(round($diff / 86400));
  }
$day_num = date('j', strtotime($date));//Day number
$month_num = date('m', strtotime($date));
$day_name = date('l', strtotime($date));
$year = date('y', strtotime($date));
$day_abrev = date('S', strtotime($date));
$day = "$day_num";  
$date = date("Y-m-d", strtotime($date));
$month = date('m');
@endphp
  @foreach( $EmpSer as $emp )
  @foreach($getDemande as $value)
      @php
      $dayNum = date('j', strtotime($value->dateDebut));
      $dateDiff = dateDiffInDays($value->dateDebut, $value->dateFin);
      $day_name = date('l', strtotime($value->dateDebut));
      @endphp
    <tr>
      <td>{{ $emp->nom }} {{ $emp->prenom }}</td>
      @for ($i = 1; $i <= $m; $i++)
      @if($i==$dayNum and $value->demandeur==$emp->nom)
      @for ($i = 0; $i <= $dateDiff; $i++)
      @if($day_name=="Sunday" or $day_name=="Saturday")
      <td id="ajouter" style="background-color:gray;"></th>
      @else
      @if($value->statut=="EnCours")
      <td id="ajouter" style="background-color:lightblue;"><a style="color:black" href = 'mesConges/edit/{{ $value->id }}'>CP</a></td>
      @elseif($value->statut=="Valide")
      <td id="ajouter" style="background-color:lightgreen;" onclick="openForm()" >CP</th>
      @elseif($value->statut=="Refuse")
      <td id="ajouter" style="background-color:red;">CP</th>
      @endif
      @endif
      @endfor
      @else
      <td id="ajouter"></td>
      @endif
        @endfor
    </tr>
    <div id="modal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onclick="closeForm()">&times;</span>
    <form action="/employes" method="POST">
    {{ csrf_field() }}
    <p>{{ $emp->nom }} {{ $emp->prenom }}</p>
    <button type="submit" class="btn btn-primary" id="ajouter-button">AJOUTER</button>
</form>
  </div>

</div>
    @endforeach
    @endforeach
    <tr>
      <td>TOTAL :</td>
      @for ($i = 1; $i < $m; $i++)
        <td></td>
        @endfor
    </tr> 
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