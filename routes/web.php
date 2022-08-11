<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testController;
use App\Http\Controllers\ActivitesController;
use App\Http\Controllers\dureeController;
use App\Http\Controllers\PageEmployesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StructuresController;
use App\Http\Controllers\DemandeCongeUser;
use App\Http\Controllers\DemandeCongeAdmin;
use App\Http\Controllers\depHorController;
use App\Http\Controllers\FicheHoraireUserController;
use App\Http\Controllers\FicheHoraireAdminController;
use App\Http\Controllers\secretController;
use App\Http\Controllers\passreset;
use App\Http\Controllers\historique;
use App\Models\structures;


Route::get('/resetPassA', [passreset::class, 'index']);
Route::post('/resetPassA', [passreset::class, 'updatePassword'])->name('update-password');
Route::get('/resetPassU', [passreset::class, 'index']);
Route::post('/resetPassU', [passreset::class, 'updatePassword'])->name('update-password');
Route::get('forgotpass', [passreset::class, 'showforgot']);
Route::post('forgotpass', [passreset::class, 'changepass']);
Route::get('changerInformations', [passreset::class, 'changeinfo'])->name('changer-info');
Route::post('changerInformations', [passreset::class, 'updateinfo']);






/*
|--------------------------------------------------------------------------
| Activites
|--------------------------------------------------------------------------
*/
Route::get('activites', [ActivitesController::class, 'index'])->name('activites');;
Route::post('activites', [ActivitesController::class, 'store']);
Route::get('/activites/edit/{id}',[ActivitesController::class, 'show']);
Route::post('/activites/edit/{id}',[ActivitesController::class, 'edit']);
Route::post('/activites/export', [ActivitesController::class, 'export'])->name('activites.details');;


/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/
Route::get('services', [ServicesController::class, 'index']);
Route::post('services', [ServicesController::class, 'store']);
Route::get('/services/edit/{id}',[ServicesController::class, 'show']);
Route::post('/services/edit/{id}',[ServicesController::class, 'edit']);
Route::post('/services/export', [ServicesController::class, 'export'])->name('services.details');


/*
|--------------------------------------------------------------------------
| Structures
|--------------------------------------------------------------------------
*/
Route::get('structures', [StructuresController::class, 'index']);
Route::post('structures', [StructuresController::class, 'store']);
Route::get('/structures/edit/{id}',[StructuresController::class, 'show']);
Route::post('/structures/edit/{id}',[StructuresController::class, 'edit']);
Route::post('/structures/export', [StructuresController::class, 'export'])->name('structures.details');
/*
|--------------------------------------------------------------------------
| Durée de pause
|--------------------------------------------------------------------------
*/
Route::get('dureePause', [dureeController::class, 'index']);
Route::post('dureePause', [dureeController::class, 'store']);
Route::get('/dureePause/edit/{id}',[dureeController::class, 'show']);
Route::post('/dureePause/edit/{id}',[dureeController::class, 'edit']);
Route::post('/dureePause/export', [dureeController::class, 'export'])->name('durees.details');

/*
|--------------------------------------------------------------------------
| Employés
|--------------------------------------------------------------------------
*/
Route::get('/employes/{id}', [PageEmployesController::class, 'show']);
Route::get('/employes', [PageEmployesController::class, 'index']);
Route::post('/employes', [PageEmployesController::class, 'store']);
Route::post('/employes/admin', [PageEmployesController::class, 'vueAdmin']);
Route::post('/employes/direction', [PageEmployesController::class, 'vueDirection']);
Route::get('/RH/{id}', [PageEmployesController::class, 'showRH']);
Route::post('/RH/{id}', [PageEmployesController::class, 'ventila']);
Route::get('/ventilation/{id}', [PageEmployesController::class, 'showVenti']);
Route::get('/statistiques/{id}', [PageEmployesController::class, 'showStat']);
Route::get('/RH/semaineType/{id}', [PageEmployesController::class, 'showST']);
Route::post('/RH/semaineType/{id}', [PageEmployesController::class, 'ajouterST']);
Route::post('/searchFiche/{id}', [PageEmployesController::class, 'searchFiche']);
Route::get('/FicheHoraire/{id}', [PageEmployesController::class, 'showFiche'])->name('fiches');
Route::post('/FicheHoraire/{id}', [PageEmployesController::class, 'activerAcces'])->name('activerAcces');
Route::post('/Fichehoraire/{id}/export', [PageEmployesController::class, 'export'])->name('AllFiches.details');
Route::get('/FicheHoraire/Details/{id}/{idfiche}', [PageEmployesController::class, 'showFicheComplete']);
Route::post('/FicheHoraire/Details/{id}/{idfiche}/export', [PageEmployesController::class, 'export2'])->name('fichesDetails.details');
Route::post('/FicheHoraire/Details/confirm/{id}/{idfiche}', [PageEmployesController::class, 'confirm']);
Route::post('/FicheHoraire/Details/refuse/{id}/{idfiche}', [PageEmployesController::class, 'refuse']);
Route::post('/FicheHoraire/Details/{id}/{idfiche}', [PageEmployesController::class, 'confirmAll']);
Route::post('/FicheHoraire/Details/direction', [PageEmployesController::class, 'VueDirectionFiche']);
Route::post('/FicheHoraire/Details/admin', [PageEmployesController::class, 'VueAdminFiche']);
Route::post('/FicheHoraire/Details/valider', [PageEmployesController::class, 'validerFicheDir']);
Route::post('/FicheHoraire/Details/validerRS', [PageEmployesController::class, 'validerFicheRS']);
Route::post('/ventilation/validerVentil', [PageEmployesController::class, 'validerVentil']);
Route::post('/search', [PageEmployesController::class, 'search']);
Route::post('/ventilation/{id}', [PageEmployesController::class, 'searchventi']);
Route::post('/statistiques/{id}', [PageEmployesController::class, 'searchStat']);
Route::get('/MesStatistiques', [FicheHoraireUserController::class, 'mesStats']);
Route::post('/MesStatistiques', [FicheHoraireUserController::class, 'searchStat']);
Route::post('/ajouterFiche', [PageEmployesController::class, 'ajouterFiche']);
Route::post('/FicheHoraire/Details/user/{idfiche}/{idUser}', [PageEmployesController::class, 'VueUserFiche']);
Route::get('/FicheHoraire/Details/user/{idfiche}/{idUser}', [PageEmployesController::class, 'VueUserFiche'])->name('ficheBack');
Route::get('/edit/utilisateur/{id}/{idUser}', [PageEmployesController::class, 'showDetails']);
Route::post('/edit/utilisateur/{id}/{idUser}',[PageEmployesController::class, 'editFiche']);
Route::post('/FicheHoraire/Details/user/{idfiche}/{idUser}/valider', [PageEmployesController::class, 'ValiderFicheHoraire']);






/*
|--------------------------------------------------------------------------
| DemandeConge User :
|--------------------------------------------------------------------------
*/

Route::get('/user/demandeConge', [DemandeCongeUser::class, 'index']);
Route::post('/demandeConge', [DemandeCongeUser::class, 'store']);
Route::get('/demandeConge', [DemandeCongeUser::class, 'verify']);
Route::get('/demandeConge', [DemandeCongeUser::class, 'verifyDate']);

/*
|--------------------------------------------------------------------------
| Fiche horaire User :
|--------------------------------------------------------------------------
*/

Route::get('/FicheHoraire', [FicheHoraireUserController::class, 'index'])->name('ficheHoraireUser');
Route::post('/FicheHoraire', [FicheHoraireUserController::class, 'addDays']);
Route::get('/FicheHoraire/edit/{id}', [FicheHoraireUserController::class, 'show']);
Route::post('/FicheHoraire/edit/{id}',[FicheHoraireUserController::class, 'edit']);
Route::post('/FicheHoraire/ediit/{id}', [FicheHoraireUserController::class, 'nextD']);
Route::post('/FicheHoraire/valider', [FicheHoraireUserController::class, 'validerFiche']);


/*
|--------------------------------------------------------------------------
| historique User :
|--------------------------------------------------------------------------
*/
Route::get('/historique', [historique::class, 'index']);
Route::post('/historique', [historique::class, 'AjouterFiche']);
Route::get('/historiqueDetails/{idfiche}', [historique::class, 'details']);
Route::get('/historiqueDetails/FicheHoraire/edit/{id}', [historique::class, 'show']);
Route::post('/historiqueDetails/FicheHoraire/edit/{id}',[historique::class, 'edit']);
Route::post('/searchFiches', [historique::class, 'search']);


/*
|--------------------------------------------------------------------------
| Fiche horaire Admin :
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| DemandeCongeAdmin :
|--------------------------------------------------------------------------
*/


Route::get('/mesConges', [DemandeCongeAdmin::class, 'index']);
Route::post('/demandeConge', [DemandeCongeAdmin::class, 'store']);
Route::get('/mesConges/edit/{id}',[DemandeCongeAdmin::class, 'show']);
Route::post('/mesConges/refuse/{id}',[DemandeCongeAdmin::class, 'refuse']);
Route::post('/mesConges/confirm/{id}',[DemandeCongeAdmin::class, 'confirm']);

/*
|--------------------------------------------------------------------------
| Depassement horaire admin :
|--------------------------------------------------------------------------
*/

Route::get('/depassementHoraire', [depHorController::class, 'index']);
Route::post('/depassementHoraire', [depHorController::class, 'store']);




/*
|--------------------------------------------------------------------------
| Autres :
|--------------------------------------------------------------------------
*/
Route::get('/secret', [secretController::class, 'index']);
Route::post('/secret', [secretController::class, 'deleteFiches']);
Route::get('/', [testController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
