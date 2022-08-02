@extends('USER.LAYOUTS.layout')
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/navbar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/ficheHoraire.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('/css/USER/reglages.css') }}" />
<title>modifier mes horaires</title>

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
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
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
    <input type="time" name="morningS" class="morningS" id="morningS"onblur="Hourdiffenrence()"value="{{$debutMLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="morningS" class="morningS" id="morningS" onblur="Hourdiffenrence()"value="{{$debutMMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="morningS" class="morningS" id="morningS" onblur="Hourdiffenrence()"value="{{$debutMMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="morningS" class="morningS" id="morningS" onblur="Hourdiffenrence()"value="{{$debutMJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="morningS" class="morningS" id="morningS" onblur="Hourdiffenrence()"value="{{$debutMVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="morningS" class="morningS" id="morningS" onblur="Hourdiffenrence()" value="{{$debutMSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="morningS" class="morningS" id="morningS" onblur="Hourdiffenrence()"value="{{$debutMDimanche}}"/>
@endif
</div>
<div id="FiMatDiv">
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="morningF" class="morningF" id="morningF" onblur="Hourdiffenrence()"value="{{$finMLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="morningF"  class="morningF"id="morningF"onblur="Hourdiffenrence()"value="{{$finMMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="morningF" class="morningF" id="morningF"onblur="Hourdiffenrence()"value="{{$finMMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="morningF"  class="morningF"id="morningF"onblur="Hourdiffenrence()"value="{{$finMJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="morningF"  class="morningF"id="morningF"onblur="Hourdiffenrence()"value="{{$finMVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="morningF"  class="morningF"id="morningF"onblur="Hourdiffenrence()"value="{{$finMSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="morningF"  class="morningF"id="morningF"onblur="Hourdiffenrence()"value="{{$finMDimanche}}"/>
@endif
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
    <input type="time" name="ApremS"  class="ApremS" id="ApremS" onblur="Hourdiffenrence()"value="{{$debutALundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="ApremS"  class="ApremS"id="ApremS"onblur="Hourdiffenrence()"value="{{$debutAMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="ApremS"  class="ApremS"id="ApremS"value="{{$debutAMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="ApremS"  class="ApremS"id="ApremS"onblur="Hourdiffenrence()"value="{{$debutAJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="ApremS"  class="ApremS"id="ApremS"onblur="Hourdiffenrence()"value="{{$debutAVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="ApremS"  class="ApremS"id="ApremS"onblur="Hourdiffenrence()"value="{{$debutASamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="ApremS"  class="ApremS"id="ApremS"onblur="Hourdiffenrence()"value="{{$debutADimanche}}"/>
@endif
</div>
<div>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="ApremF"  class="ApremF"id="ApremF"onblur="Hourdiffenrence()"value="{{$finALundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="ApremF" class="ApremF"id="ApremF"onblur="Hourdiffenrence()"value="{{$finAMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="ApremF" class="ApremF"id="ApremF"onblur="Hourdiffenrence()"value="{{$finAMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="ApremF" class="ApremF"id="ApremF"onblur="Hourdiffenrence()"value="{{$finAJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="ApremF" class="ApremF"id="ApremF"onblur="Hourdiffenrence()"value="{{$finAVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="ApremF" class="ApremF"id="ApremF"onblur="Hourdiffenrence()"value="{{$finASamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="ApremF" class="ApremF"id="ApremF"onblur="Hourdiffenrence()"value="{{$finADimanche}}"/>
@endif
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
    <input type="time" name="soirS" id="soirS"onblur="Hourdiffenrence()" value="{{$debutSLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="soirS" id="soirS"onblur="Hourdiffenrence()"  value="{{$debutSMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="soirS" id="soirS"onblur="Hourdiffenrence()"  value="{{$debutSMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="soirS" id="soirS"onblur="Hourdiffenrence()"  value="{{$debutSJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="soirS"  id="soirS"onblur="Hourdiffenrence()" value="{{$debutSVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="soirS"  id="soirS"onblur="Hourdiffenrence()" value="{{$debutSSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="soirS"  id="soirS"onblur="Hourdiffenrence()" value="{{$debutSDimanche}}"/>
@endif
</div>
<div>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="soirF"  id="soirF"onblur="Hourdiffenrence()" value="{{$finSLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="soirF" id="soirF"onblur="Hourdiffenrence()"value="{{$finSMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="soirF" id="soirF"onblur="Hourdiffenrence()"value="{{$finSMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="soirF" id="soirF"onblur="Hourdiffenrence()"value="{{$finSJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="soirF" id="soirF"onblur="Hourdiffenrence()"value="{{$finSVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="soirF" id="soirF"onblur="Hourdiffenrence()"value="{{$finSSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="soirF" id="soirF"onblur="Hourdiffenrence()"value="{{$finSDimanche}}"/>
@endif
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
                <td><input onblur="findTotal()" class="nume" name="{{ $ven->codeV }}" type="number" placeholder="" step="0.01" min="0"></td>
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


diffHoursE = parseInt(0+(AfternoonE.split(":")[0])) - parseInt(0+(morningE.split(":")[0]))
diffHoursS = parseInt(0+(AfternoonS.split(":")[0])) - parseInt(0+(morningS.split(":")[0]))
diffHoursSoir = parseInt(0+(soirF.split(":")[0])) - parseInt(0+(soirS.split(":")[0]))
diffMinutesE = parseInt(0+(AfternoonE.split(":")[1])) - parseInt(0+(morningE.split(":")[1]))
diffMinutesS = parseInt(0+(AfternoonS.split(":")[1])) - parseInt(0+(morningS.split(":")[1]))
diffMinutesSoir = parseInt(0+(soirF.split(":")[1])) - parseInt(0+(soirS.split(":")[1]))
if (isNaN(diffHoursE)) {
     diffHoursE=0;
}
if(isNaN(diffHoursS)) {
     diffHoursS=0;
}
if(isNaN(diffMinutesE)) {
    diffMinutesE=0;
}
if(isNaN(diffMinutesS)) {
    diffMinutesS=0;
}
if(isNaN(diffHoursSoir)) {
    diffHoursSoir=0;
}if(isNaN(diffMinutesSoir)) {
    diffMinutesSoir=0;
}
// Result
let res = (result = diffHoursE + diffHoursS + diffHoursSoir +(diffMinutesE + diffMinutesS + diffMinutesSoir)/60) //6.5

document.getElementById('totalheures').value = res;
}
</script>
@endsection
  