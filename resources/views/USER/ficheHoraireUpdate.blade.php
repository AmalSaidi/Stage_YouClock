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
<input type="hidden" name="typeJour">
<select name="typeJour" id="typeJour">
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
</select></input>
<div class="form-group">
    <h5 id="mat">Matin</h5>
<input type="hidden" name="TM">
<select name="TM" id="TM">
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
</select></input>
<br>
<div id="DeMatDiv">
<p>Heure de début</p>

@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="morningS" value="{{$debutMLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="morningS" value="{{$debutMMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="morningS" value="{{$debutMMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="morningS" value="{{$debutMJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="morningS" value="{{$debutMVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="morningS" value="{{$debutMSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="morningS" value="{{$debutMDimanche}}"/>
@endif
</div>
<div id="FiMatDiv">
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="morningF" value="{{$finMLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="morningF" value="{{$finMMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="morningF" value="{{$finMMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="morningF" value="{{$finMJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="morningF" value="{{$finMVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="morningF" value="{{$finMSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="morningF" value="{{$finMDimanche}}"/>
@endif
</div>
</div>
<div class="form-group">
    <h5 id="apr">Après-midi</h5>
    <input type="hidden" name="TAP"><select id="TAP" name="TAP" id="">
    @foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
</select></input>
<br>
<div id="DeApremDiv">
<p>Heure de début</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="ApremS" value="{{$debutALundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="ApremS" value="{{$debutAMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="ApremS" value="{{$debutAMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="ApremS" value="{{$debutAJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="ApremS" value="{{$debutAVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="ApremS" value="{{$debutASamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="ApremS" value="{{$debutADimanche}}"/>
@endif
</div>
<div>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="ApremF" value="{{$finALundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="ApremF" value="{{$finAMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="ApremF" value="{{$finAMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="ApremF" value="{{$finAJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="ApremF" value="{{$finAVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="ApremF" value="{{$finASamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="ApremF" value="{{$finADimanche}}"/>
@endif
</div>
</div>
<div class="form-group">
    <h5 id="soir">Soir</h5>
<input type="hidden" name="TS"><select name="TS" id="TS">
@foreach($activites as $act)
              <option value="{{ $act->code }}">activité : {{ $act->code }}</option>
              @endforeach
</select></input>
<br>
<div id="DeSoirDiv">
<p>Heure de début</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="soirS" value="{{$debutSLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="soirS" value="{{$debutSMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="soirS" value="{{$debutSMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="soirS" value="{{$debutSJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="soirS" value="{{$debutSVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="soirS" value="{{$debutSSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="soirS" value="{{$debutSDimanche}}"/>
@endif
</div>
<div>
<p>Heure de fin</p>
@if(str_contains($affichage[0]->Date, 'Lun'))
    <input type="time" name="soirF" value="{{$finSLundi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mar'))
    <input type="time" name="soirF" value="{{$finSMardi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Mer'))
    <input type="time" name="soirF" value="{{$finSMercredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Jeu'))
    <input type="time" name="soirF" value="{{$finSJeudi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Ven'))
    <input type="time" name="soirF" value="{{$finSVendredi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Sam'))
    <input type="time" name="soirF" value="{{$finSSamedi}}"/>
@elseif(str_contains($affichage[0]->Date, 'Dim'))
    <input type="time" name="soirF" value="{{$finSDimanche}}"/>
@endif
</div>
</div>
<div class="form-group">
    <h5 id="ventilation-titre">Ventilation</h5>
    <table>
        <tbody>
        @foreach($ventil as $ven)
            <tr>
                <td>{{ $ven->ventilation }}</td>
                <td><input onblur="findTotal()" class="nume" name="{{ $ven->codeV }}" type="number" placeholder="" step="0.01" min="0" max="10"></td>
            </tr>
         @endforeach
        </tbody>
    </table>
    <div>
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
    var arr = document.getElementsByClassName('nume');
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
  