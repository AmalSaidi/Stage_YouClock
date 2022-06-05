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
<div id="calendar">
<table class="table" id="current-month">
        <thead class="thead">
    <tr id="head-table">
      <th scope="col">{{ $month }} {{ $year }}</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
  <table class="table-bordered" id="MyTable">
  <thead>
    <th>Lundi</th>
    <th>Mardi</th>
    <th>Mercredi</th>
    <th>Jeudi</th>
    <th>Vendredi</th>
    <th>Samedi</th>
    <th>Dimanche</th>
  </thead>
  <tbody>
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
    @if ($row_count%7==0)
      <tr>
      @php
      $col_count=1;
      @endphp
    @endif
    @if ($day_name=="Sunday" and $day_num==1 and $month_num == $month)
      @for ($i = 0; $i < 6; $i++)
        <td></td>
        @php
          $col_count++;
          $row_count++;
        @endphp
      @endfor
    
    @elseif ($day_name=="Tuesday" and $day_num==1 and $month_num == $month)
      @for ($i = 0; $i < 1; $i++)
        <td></td>
        @php
          $col_count++;
          $row_count++;
        @endphp
      @endfor

    @elseif ($day_name=="Wednesday" and $day_num==1 and $month_num == $month)
      @for ($i = 0; $i < 2; $i++)
        <td></td>
        @php
          $col_count++;
          $row_count++;
        @endphp
      @endfor

    @elseif ($day_name=="Thursday" and $day_num==1 and $month_num == $month)
      @for ($i = 0; $i < 3; $i++)
        <td></td>
        @php
          $col_count++;
          $row_count++;
        @endphp
      @endfor

    @elseif ($day_name=="Friday" and $day_num==1 and $month_num == $month)
      @for ($i = 0; $i < 4; $i++)
        <td></td>
        @php
          $col_count++;
          $row_count++;
        @endphp
      @endfor

    @elseif ($day_name=="Saturday" and $day_num==1 and $month_num == $month)
      @for ($i = 0; $i < 5; $i++)
        <td></td>
        @php
          $col_count++;
          $row_count++;
        @endphp
      @endfor

    @endif
    @if($month_num == $month)
    <td id="hehe" onclick="showDay('{{ $day }}')">{{ $day }}</td>
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
     @if($col_count==7)
      </tr>
     @endif
     @php
      $row_count++; 
      $col_count++; 
      $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
     @endphp
  @endwhile




  </tbody>
</table>

</div>

<div>
</div>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Demande de congé</h3>
    <hr>
    <form action="/demandeConge" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
  <select name="type" id="typeConge">
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
  <div class="form-group1" style="float:left;">
  <label for="start">Date de début</label><br>
  <input type="date" id="start" name="start">
  </div>
  <div class="form-group2">
  <label for="start">Date de fin</label><br>
  <input type="date" id="fin" name="fin">
  </div>
  <div class="form-group3">
  <label for="start">Date de retour</label><br>
  <input type="date" id="retour" name="retour">
  <p>Nombre de congé : 7j</p>
  </div>
  <button type="submit" class="btn btn-primary" id="ajouter-button">ENVOYER LA DEMANDE</button>
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
@endsection
  