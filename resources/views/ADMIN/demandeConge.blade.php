
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
  <!-- <button type="button" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button> -->
  <button id="ajouter"> ajouter un employé
</button>
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
    @if($month_num == $month)
    <th id="hehe" onclick="showDay('{{ $day }}')">{{ $day }}</th>
      @foreach($conge as $value)
      @if($value->dateDebut > $date and $value->dateFin < $date)
        <style>
          table.table-bordered td{  background-color: black}
        </style>
        @else
        <script>
          const url_table = document.getElementById("MyTable").rows
          var post_urls = [];
          for (let i = 0; i < url_table.length; i++) {
              post_urls.push(url_table[i].cells[0].innerText);
          }
        </script>
        @endif
      @endforeach
    @endif
     @php
      $row_count++; 
      $col_count++; 
      $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
     @endphp
  @endwhile

  </thead>
  <tbody>
  @foreach( $EmpSer as $emp )
    <tr>
      <td>{{ $emp->nom }} {{ $emp->prenom }}</td>
      @for ($i = 1; $i <= $m; $i++)
        <td></td>
        @endfor
    </tr>
    @endforeach
    <tr>
      <td>TOTAL :</td>
      @for ($i = 1; $i <= $m; $i++)
        <td></td>
        @endfor
    </tr>

  </tbody>
</table>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/modifier_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}">
    </script>
  
  @endsection

