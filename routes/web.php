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
use App\Models\structures;

/*
|--------------------------------------------------------------------------
| Activites
|--------------------------------------------------------------------------
*/
Route::get('activites', [ActivitesController::class, 'index']);
Route::post('activites', [ActivitesController::class, 'store']);
Route::get('/activites/edit/{id}',[ActivitesController::class, 'show']);
Route::post('/activites/edit/{id}',[ActivitesController::class, 'edit']);
/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/
Route::get('services', [ServicesController::class, 'index']);
Route::post('services', [ServicesController::class, 'store']);
Route::get('/services/edit/{id}',[ServicesController::class, 'show']);
Route::post('/services/edit/{id}',[ServicesController::class, 'edit']);
/*
|--------------------------------------------------------------------------
| Structures
|--------------------------------------------------------------------------
*/
Route::get('structures', [StructuresController::class, 'index']);
Route::post('structures', [StructuresController::class, 'store']);
Route::get('/structures/edit/{id}',[StructuresController::class, 'show']);
Route::post('/structures/edit/{id}',[StructuresController::class, 'edit']);
/*
|--------------------------------------------------------------------------
| Durée de pause
|--------------------------------------------------------------------------
*/
Route::get('dureePause', [dureeController::class, 'index']);
Route::post('dureePause', [dureeController::class, 'store']);
Route::get('/dureePause/edit/{id}',[dureeController::class, 'show']);
Route::post('/dureePause/edit/{id}',[dureeController::class, 'edit']);
/*
|--------------------------------------------------------------------------
| Employés
|--------------------------------------------------------------------------
*/
Route::get('/employes/{id}', [PageEmployesController::class, 'show']);
Route::get('/employes', [PageEmployesController::class, 'index']);
Route::get('/employes/ajouter',[PageEmployesController::class, 'store']);
Route::get('/employes/ajouter',[PageEmployesController::class, 'store']);
Route::get('/RH/{id}', [PageEmployesController::class, 'showRH']);
Route::get('/FicheHoraire/{id}', [PageEmployesController::class, 'showFiche']);



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

/*
|--------------------------------------------------------------------------
| Autres :
|--------------------------------------------------------------------------
*/

Route::get('/', [testController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
