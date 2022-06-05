@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/ADMIN/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/demandeConge.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<script>
  
</script>
@section('content')
@foreach( $employes as $employe )
<div id="menu-reg">
    <img id="logo-icon" src="https://cdn.discordapp.com/attachments/936584358654005321/974610254220378112/user.png">
    <BR>
    <div id="info-user"><p>{{ $employe->nom }} {{ $employe->prenom }}</p></div>
<div id="stru-user">{{ $employe->structure }}</div>
<table class="table-borderless">
  <tbody>

  <tr>
      <td>CP</td>
      <td>7j</td>
    </tr>
    <tr>
      <td>RTT</td>
      <td>1j</td>
    </tr>
    <tr>
      <td>RCR</td>
      <td>2j</td>
    </tr>
  </tbody>
</table>
</div>
  
@endforeach
  
<div id="acti">
<h3>Mes congés</h3>
<br>
<div id="button-list">
<button id="ajouter">Demander un congé
</button>
</div>
@php
$year = date('Y');
$month = date('m');
if($month==01){
    $month="Janvier";
    }
else if($month==02){
    $month="Février";
    }
else if($month==03){
    $month="Mars";
    }
else if($month==04){
    $month="Avril";
    }
else if($month==05){
    $month="Mai";
    }
else if($month==06){
    $month="Juin";
    }
else if($month==07){
    $month="Juillet";
    }
else if($month==08){
    $month="Août";
    }
else if($month==09){
    $month="Septembre";
    }
else if($month==10){
    $month="Octobre";
    }
else if($month==11){
    $month="Novembre";
    }
else if($month==12){
    $month="Décembre";
    }
@endphp    
<div id="calendar">
<table class="table">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">{{ $month }} {{ $year }}</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
<table class="table-bordered">
  <tbody>
@php
$date = date('F Y');//Current Month Year
$row_count=0;
$col_count=0;

while (strtotime($date) <= strtotime(date('Y-m') . '-' . date('t', strtotime($date)))) {
if($row_count%4==0){
        echo "<tr>";
        $col_count=1;
     }
    $day_num = date('j', strtotime($date));//Day number
    $month_num = date('m', strtotime($date));
    $day_name = date('l', strtotime($date));
    if($day_name=="Monday"){
    $day_name="Lundi";
    }
    else if($day_name=="Tuesday"){
    $day_name="Mardi";
    }
    else if($day_name=="Wednesday"){
    $day_name="Mercredi";
    }
    else if($day_name=="Thursday"){
    $day_name="Jeudi";
    }
    else if($day_name=="Friday"){
    $day_name="Vendredi";
    }
    else if($day_name=="Saturday"){
    $day_name="Samedi";
    }
    else if($day_name=="Sunday"){
    $day_name="Dimanche";
    }
    $day_abrev = date('S', strtotime($date));
    $day = "$day_num";
    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));//Adds 1 day onto current date
    echo '<td>' . $day . '</td>';
    if($col_count==4){
           echo "</tr>";
        }
        $row_count++; 
        $col_count++; 
}
@endphp
  </tbody>
</table>

</div>

<div>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <h3>Demande de congé</h3>
    <span class="close">&times;</span>
    <form action="/demandeConge" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
  <select name="type">
    <option>
      Congé payé
    </option>
    <option>
      RTT
    </option>
    <option>
      RCR
    </option>
  </select>
  </div>

@endsection
  