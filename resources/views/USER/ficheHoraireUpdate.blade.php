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
<form action = "/FicheHoraire/edit/<?php echo $affichage[0]->id; ?>" method = "post">
{!! csrf_field() !!}
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
    onblur="Hourdiffenrence()" value="{{ old('morningS',$affichage[0]->matinD) }}"  />
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" onblur="Hourdiffenrence()"value="{{ old('morningS',$affichage[0]->matinD) }}" placeholder="--,--"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningS',$affichage[0]->matinD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningS',$affichage[0]->matinD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningS',$affichage[0]->matinD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()" value="{{ old('morningS',$affichage[0]->matinD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="morningS" class="morningS" id="morningS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningS',$affichage[0]->matinD) }}"/>
@endif
</div>
<div id="FiMatDiv" id="FiMatDiv" style="float: left;
    margin-right: 120;">
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="morningF" class="morningF" id="morningF" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningF',$affichage[0]->matinF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="morningF"  class="morningF"id="morningF" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningF',$affichage[0]->matinF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="morningF" class="morningF" id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningF',$affichage[0]->matinF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningF',$affichage[0]->matinF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningF',$affichage[0]->matinF) }}""/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningF',$affichage[0]->matinF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="morningF"  class="morningF"id="morningF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('morningF',$affichage[0]->matinF) }}"/>
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
    <input type="text" name="ApremS"  class="ApremS" id="ApremS" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()" value="{{ old('ApremS',$affichage[0]->apremD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()" value="{{ old('ApremS',$affichage[0]->apremD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremS',$affichage[0]->apremD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremS',$affichage[0]->apremD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremS',$affichage[0]->apremD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremS',$affichage[0]->apremD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="ApremS"  class="ApremS"id="ApremS"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremS',$affichage[0]->apremD) }}"/>
@endif
</div>
<div style=  'float: left;
    margin-right: 120;'>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="ApremF"  class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremF',$affichage[0]->apremF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremF',$affichage[0]->apremF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremF',$affichage[0]->apremF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremF',$affichage[0]->apremF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremF',$affichage[0]->apremF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremF',$affichage[0]->apremF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="ApremF" class="ApremF"id="ApremF"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"onblur="Hourdiffenrence()"value="{{ old('ApremF',$affichage[0]->apremF) }}"/>
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
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{ old('soirS',$affichage[0]->soirD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{ old('soirS',$affichage[0]->soirD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{ old('soirS',$affichage[0]->soirD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="soirS" id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{ old('soirS',$affichage[0]->soirD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="soirS"  id="soirS"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{ old('soirS',$affichage[0]->soirD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="soirS"  id="soirS"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirS',$affichage[0]->soirD) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="soirS"  id="soirS"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$" value="{{ old('soirS',$affichage[0]->soirD) }}"/>
@endif
</div>
<div style=  'float: left;
    margin-right: 120;'>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="text" name="soirF"  id="soirF"onblur="Hourdiffenrence()" pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirF',$affichage[0]->soirF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirF',$affichage[0]->soirF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirF',$affichage[0]->soirF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirF',$affichage[0]->soirF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirF',$affichage[0]->soirF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirF',$affichage[0]->soirF) }}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="text" name="soirF" id="soirF"onblur="Hourdiffenrence()"pattern="^(0|1|2|3|4|5|6|7|8|9|00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23)+.(00|25|50|75)$"value="{{ old('soirF',$affichage[0]->soirF) }}"/>
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
        @if($MANDA==1)
            <tr>
                <td>Mandataires</td>
                <td><input onblur="findTotal()" class="nume" name="MANDA" type="number"  value="{{ old('MANDA',$affichage[0]->Mandataires	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($FRAS==1)
            <tr>
                <td>FRASAD</td>
                <td><input onblur="findTotal()" class="nume" name="FRAS" type="number" value="{{ old('FRAS',$affichage[0]->FRASAD	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($ENTRAI==1)
            <tr>
                <td> Entraide familiale</td>
                <td><input onblur="findTotal()" class="nume" name="ENTRAI" type="number" value="{{ old('ENTRAI',$affichage[0]->EntraideFamiliale) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($FEDE==1)
            <tr>
                <td>Fédération</td>
                <td><input onblur="findTotal()" class="nume" name="FEDE" type="number" value="{{ old('FEDE',$affichage[0]->Federation	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($PRES==1)
            <tr>
                <td>Prestataire</td>
                <td><input onblur="findTotal()" class="nume" name="PRES" type="number" value="{{ old('PRES',$affichage[0]->Prestataire	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($VOISI==1)
            <tr>
                <td>Voisineurs</td>
                <td><input onblur="findTotal()" class="nume" name="VOISI" type="number" value="{{ old('VOISI',$affichage[0]->Voisineurs	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($ADU==1)
            <tr>
                <td> ADU services</td>
                <td><input onblur="findTotal()" class="nume" name="ADU" type="number" value="{{ old('ADU',$affichage[0]->ADUservices	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($SOS==1)
            <tr>
                <td> SOS garde d'enfants</td>
                <td><input onblur="findTotal()" class="nume" name="SOS" type="number" value="{{ old('SOS',$affichage[0]->SOSgarde	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($ADVM==1)
            <tr>
                <td>ADVM</td>
                <td><input onblur="findTotal()" class="nume" name="ADVM" type="number" value="{{ old('ADVM',$affichage[0]->ADVM		) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
         @if($DELEG==1)
            <tr>
                <td>Délégation</td>
                <td><input onblur="findTotal()" class="nume" name="DELEG" type="number" value="{{ old('DELEG',$affichage[0]->DELEGATION	) }}" placeholder="" step="0.01" min="0"></td>
            </tr>
         @endif
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
    const genderOldValue = '{{ old('TM',$affichage[0]->activite1)  }}';
    
    if(genderOldValue !== '') {
      $('#TM').val(genderOldValue);
    }
  });
</script>
<script>
  $(document).ready(function() {
    const genderOldValue = '{{ old('TAP',$affichage[0]->activite2) }}';
    
    if(genderOldValue !== '') {
      $('#TAP').val(genderOldValue);
    }
  });
</script>
<script>
  $(document).ready(function() {
    const genderOldValue = '{{ old('TS',$affichage[0]->activite3)  }}';
    
    if(genderOldValue !== '') {
      $('#TS').val(genderOldValue);
    }
  });
</script>
<script>
  $(document).ready(function() {
    const genderOldValue = '{{ old('typeJour',$affichage[0]->typeJour) }}';
    
    if(genderOldValue !== '') {
      $('#typeJour').val(genderOldValue);
    }
  });
</script>
@endsection
  