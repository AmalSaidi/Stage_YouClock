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

  <div id="acti">
  @if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
@endif
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
<div id="DeMatDiv">
<p>Heure de début</p>
<input type="time" name="morningS" value="09:00"/>
</div>
<div id="FiMatDiv">
<p>Heure de fin</p>
<input type="time" name="morningF" value="12:30"/>
</div>
</div>
<div class="form-group">
    <h5 id="apr">Après-midi</h5>
    <input type="hidden" name="TAP"><select id="TAP" name="TAP" id="">
    <option value="T">Activité : T</option>
    <option value=""> </option>
</select></input>
<br>
<div id="DeApremDiv">
<p>Heure de début</p>
<input type="time" name="ApremS" value="13:30"/>
</div>
<div>
<p>Heure de fin</p>
<input type="time" name="ApremF" value="17:00"/>
</div>
</div>
<div class="form-group">
    <h5 id="soir">Soir</h5>
<input type="hidden" name="TS"><select name="TS" id="TS">
    <option value=""></option>
    <option value="T">Activité : T</option>
</select></input>
<br>
<div id="DeSoirDiv">
<p>Heure de début</p>
<input type="time" name="soirS" value=" "/>
</div>
<div>
<p>Heure de fin</p>
<input type="time" name="soirF" value=" "/>
</div>
</div>
<div class="form-group">
    <h5 id="ventilation-titre">Ventilation</h5>
    <div id="venti">
    <input id="ven" type="text" placeholder="ventilation1" ><br>
    <input id="ven" type="text" placeholder="ventilation2" ><br>
    <input id="ven" type="text" placeholder="ventilation3" ><br>
    </div>
    <div>
    <input onblur="findTotal()" id="num" name="num" type="number" placeholder="" step="0.01" min="0" max="10"><br>
    <input onblur="findTotal()" id="num" name="num" type="number" placeholder="" step="0.01" min="0" max="10"><br>
    <input onblur="findTotal()" id="num" name="num" type="number" placeholder="" step="0.01" min="0" max="10"><br>
    <input name="heureseffectu" onblur="findTotal()" type="hidden" name="total" id="total" max="10"/>
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
  