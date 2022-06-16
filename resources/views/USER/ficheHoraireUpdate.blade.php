@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<style>
     #menu-reg {
    BACKGROUND-COLOR: WHITE;
    WIDTH: 19%;
    PADDING: 3% !important;
    margin-left: 2%;
    float: left;}
</style>

@section('content')
<div id="menu-reg">
    <P id="reglages">Réglages</P>
    <ul class="nav flex-column">
    <li class="reg" >
        <a class="nav-link" href="/activites">ACTIVITES</a>
      </li>
      <li class="reg" >
        <a class="nav-link" href="/structures">STRUCTURES</a>
      </li>
      <li class="reg" >
        <a class="nav-link" href="/services">SERVICES</a>
      </li>
      <li class="reg">
        <a class="nav-link" href="/dureePause">DUREE DES PAUSES</a>
      </li>
    </ul>
  </div>
  <div id="acti">
<form action = "/FicheHoraire/edit/<?php echo $affichage[0]->id; ?>" method = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<h3 id="titlee">
<?php echo $affichage[0]->Date; ?>
</h3>
<div class="form-group">
    <h5 id="mat">Matin</h5>
<input type="hidden" name="TM"><select name="TM" id="TM">
    <option value="T">Activité : T</option>
    <option value=""> </option>
</select></input>
<br>
<input type="time" name="morningS" value="09:00"/>
<input type="time" name="morningF" value="12:30"/>
</div>
<div class="form-group">
    <h5 id="apr">Après-midi</h5>
    <input type="hidden" name="TAP"><select name="TAP" id="">
    <option value="T">T</option>
    <option value=""> </option>
</select></input>
<input type="time" name="ApremS" value="13:30"/>
<input type="time" name="ApremF" value="17:00"/>
</div>
<div class="form-group">
    <h5 id="soir">Soir</h5>
<input type="hidden" name="TS"><select name="TS" id="">
    <option value=""></option>
    <option value="T">T</option>
</select></input>
<input type="time" name="soirS" value=" "/>
<input type="time" name="soirF" value=" "/>
</div>
<div class="form-group">
    <h5>Ventilation</h5>
    <input onblur="findTotal()" name="num" type="number" placeholder="" step="0.01" min="0" max="10">
    <input onblur="findTotal()" name="num" type="number" placeholder="" step="0.01" min="0" max="10">
    <input onblur="findTotal()" name="num" type="number" placeholder="" step="0.01" min="0" max="10">
    <input name="heureseffectu" onblur="findTotal()" type="text" name="total" id="total"/>
</div>
<button type="submit" class="btn btn-primary" id="ajouter-button">modifier</button>
</form>
</div>
<script type="text/javascript" src="{{ URL::asset('js/ajouter_popup.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/afficher-form-modifier.js') }}"></script>
<script type="text/javascript">

function findTotal(){
    var arr = document.getElementsByName('num');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('total').value = tot;
}

function Hourdiffenrence(){
    var d1 = document.getElementsByName('morningS');
    var d2 = document.getElementsByName('morningF');
    var diffMs = (d2 - d1);
    var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
    var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
    alert(diffHrs + " hours, " + diffMins + " minutes until Christmas 2009 =)");
}

    </script>
@endsection
  