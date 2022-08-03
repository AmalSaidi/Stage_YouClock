@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<title>modifier mes horaires</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style>
     #menu-reg {
    BACKGROUND-COLOR: WHITE;
    WIDTH: 19%;
    PADDING: 3% !important;
    margin-left: 2%;
    float: left;}
</style>

@section('content')

  <div id="acti">
  @if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
@endif
<form action = "/historiqueDetails/FicheHoraire/edit/<?php echo $affichage[0]->id; ?>" method = "post">
{!! csrf_field() !!}
<input type="hidden" name="idFi" value="<?php echo $affichage[0]->idfiche; ?>">
<h3 id="titlee">
<?php echo $affichage[0]->Date; ?>
</h3>
<input type="hidden" name="typeJour">
@if(str_contains($affichage[0]->Date, 'Sam') or str_contains($affichage[0]->Date, 'Dim'))
<select name="typeJour" id="typeJour">
        <option value="repos" selected>repos</option>
        <option value="Travaillé">Travaillé</option>
        <option value="Férié">Férié</option>
        <option value="CP">CP</option>
        <option value="RTT">RTT</option>
        <option value="1/2 RTT">1/2 RTT</option>
        <option value="RCR">RCR</option>
        <option value="Formation">Formation</option>
        <option value="Maladie">Maladie</option>
        <option value="Congés familiaux">Congés familiaux</option>
        <option value="Sans soldes">Sans soldes</option>
        <option value="Jour solidarité">Jour solidarité</option>
</select>
@else
<select name="typeJour" id="typeJour">
        <option value="repos" >repos</option>
        <option value="Travaillé" selected>Travaillé</option>
        <option value="Férié">Férié</option>
        <option value="CP">CP</option>
        <option value="RTT">RTT</option>
        <option value="1/2 RTT">1/2 RTT</option>
        <option value="RCR">RCR</option>
        <option value="Formation">Formation</option>
        <option value="Maladie">Maladie</option>
        <option value="Congés familiaux">Congés familiaux</option>
        <option value="Sans soldes">Sans soldes</option>
        <option value="Jour solidarité">Jour solidarité</option>
</select>
@endif
</input>
<div class="form-group">
    <h5 id="mat">Matin</h5>
<input type="hidden" name="TM">
@if(str_contains($affichage[0]->Date, 'Sam') or str_contains($affichage[0]->Date, 'Dim'))
<select name="TM" id="TM">
<option value="-" selected>activité : repos</option>
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
</select>
@else
<select name="TM" id="TM">
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
              <option value="-">activité : repos</option>
</select>
@endif
</input>
<br>
<div id="DeMatDiv">
<p>Heure de début</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"
    onblur="Hourdiffenrence()" value="{{old('morningS')}}"  />
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" onblur="Hourdiffenrence()"value="{{old('morningS')}}" placeholder="--,--"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()" value="{{old('morningS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningS')}}"/>
@endif
</div>
<div id="FiMatDiv" id="FiMatDiv" style="float: left;
    margin-right: 120;">
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="morningF" class="morningF" id="morningF" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="morningF"  class="morningF"id="morningF" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="morningF" class="morningF" id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('morningF')}}"/>
@endif
</div>
<div id="totMat">
<p>total</p>
<input onblur="heureMat()" style=" width: 100;" type="text" name="heureMat" id="heureMat" disabled/>
</div>
</div>
<div class="form-group">
    <h5 id="apr">Après-midi</h5>
    <input type="hidden" name="TAP">
    @if(str_contains($affichage[0]->Date, 'Sam') or str_contains($affichage[0]->Date, 'Dim'))
<select name="TAP" id="TAP">
<option value="-" selected>activité : repos</option>
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
</select>
@else
<select name="TAP" id="TAP">
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
              <option value="-">activité : repos</option>
</select>
@endif
</input>
<br>
<div id="DeApremDiv">
<p>Heure de début</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="ApremS"  class="ApremS" id="ApremS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremS')}}"/>
@endif
</div>
<div style=  'float: left;
    margin-right: 120;'>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="ApremF"  class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{old('ApremF')}}"/>
@endif
</div>
<div id="totAprem">
<p>total</p>
<input onblur="Hourdiffenrence()" style=" width:100;" type="text" name="heureApr" id="heureApr" max="10" disabled/>
</div>
</div>
<div class="form-group">
    <h5 id="soir">Soir</h5>
<input type="hidden" name="TS">@if(str_contains($affichage[0]->Date, 'Sam') or str_contains($affichage[0]->Date, 'Dim'))
<select name="TS" id="TS">
<option value="-" selected>activité : repos</option>
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
</select>
@else
<select name="TS" id="TS">
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
              <option value="-">activité : repos</option>
</select>
@endif</input>
<br>
<div id="DeSoirDiv">
<p>Heure de début</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{old('soirS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{old('soirS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{old('soirS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{old('soirS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="soirS"  id="soirS"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{old('soirS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="soirS"  id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirS')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="soirS"  id="soirS"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{old('soirS')}}"/>
@endif
</div>
<div style=  'float: left;
    margin-right: 120;'>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="soirF"  id="soirF"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirF')}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{old('soirF')}}"/>
@endif
</div>
<div>
<p>total</p>
<input onblur="" style=" width:100;" type="text" name="heureSoir" id="heureSoir"  disabled/>
</div>
</div>
<div class="form-group">
<h5 id="ventilation-titre">Total effectué</h5>
<input name="heureseffectu" onblur="Hourdiffenrence()" style=" width: 310;" type="text" name="totalheures" id="totalheures" max="10" disabled/>
<button type="button" style="background-color:#67b367; " onclick="Hourdiffenrence()" >Actualiser</button>
</div>
<div class="form-group">
    <h5 id="ventilation-titre">Ventilation</h5>
    <table>
        <tbody>
        @foreach($ventil as $ven)
            <tr>
                <td>{{ $ven->ventilation }}</td>
                <td><input onblur="findTotal()"  class="nume" name="{{ $ven->codeV }}" type="number" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endforeach
        </tbody>
    </table>
    <div>
    <input name="heureseffectu" onblur="findTotal()" type="hidden" name="total" id="total"/>
    </div>
</div>
<button type="submit" class="btn btn-primary" id="ajouter-button">Valider</button>
</form>

@foreach($last as $lastt)
@if($affichage[0]->id!=$lastt->id)
<form action = "/FicheHoraire/ediit/<?php echo $affichage[0]->id; ?>" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <!--<button type="hidden" class="btn btn-primary" id="jourS-button">Jour suivant</button> -->
</form>
@endif
@endforeach

</div>
<script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>
<script type="text/javascript">
function findTotal(){
    var arr = document.getElementsByClassName('nume');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    //document.getElementById('total').value = tot;
}

function Hourdiffenrence(){
const morningS = document.getElementById('morningS').value;
const morningE =  document.getElementById('ApremS').value;
const AfternoonS =  document.getElementById('morningF').value;
const AfternoonE = document.getElementById('ApremF').value;
const soirS = document.getElementById('soirS').value;
const soirF =  document.getElementById('soirF').value;


diffHoursE = AfternoonE - morningE
diffHoursS = AfternoonS - morningS
diffHoursSoir = soirF - soirS
if (diffHoursE<=0) {
     diffHoursE=0;
}
if(diffHoursS<=0) {
     diffHoursS=0;
}
if(diffHoursSoir<=0) {
    diffHoursSoir=0;
}
// Result
let res = (result = diffHoursE + diffHoursS + diffHoursSoir) //6.5
document.getElementById('totalheures').value = res;
document.getElementById('heureMat').value = diffHoursS;
document.getElementById('heureSoir').value = diffHoursSoir;
document.getElementById('heureApr').value = diffHoursE;

}

</script>
<script>
  $(document).ready(function() {
    const genderOldValue = '{{ old('TM') }}';
    
    if(genderOldValue !== '') {
      $('#TM').val(genderOldValue);
    }
  });
</script>
<script>
  $(document).ready(function() {
    const genderOldValue = '{{ old('TAP') }}';
    
    if(genderOldValue !== '') {
      $('#TAP').val(genderOldValue);
    }
  });
</script>
<script>
  $(document).ready(function() {
    const genderOldValue = '{{ old('TS') }}';
    
    if(genderOldValue !== '') {
      $('#TS').val(genderOldValue);
    }
  });
</script>
<script>
  $(document).ready(function() {
    const genderOldValue = '{{ old('typeJour') }}';
    
    if(genderOldValue !== '') {
      $('#typeJour').val(genderOldValue);
    }
  });
</script>

@endsection
  