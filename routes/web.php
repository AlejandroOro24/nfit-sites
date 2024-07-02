<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Plans\PlanController;
use App\Http\Controllers\Videos\VideoController;
use App\Http\Controllers\users\DashboardController;
use App\Http\Controllers\users\clases\ClaseController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\users\profile\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/' , [HomeController::class, 'index'])->name('home');


Route::domain('{tenant}.'. ENV('APP_URL'))->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    //clases
    Route::get('/clases', [ClaseController::class, 'index'])->name('user.clases.index');
    Route::get('/clases/types' , [ClaseController::class, 'getTypes'] );
    Route::get('/clases/week/{clase}', [ClaseController::class, 'getWeek']);
    Route::get('/clases/blocks/{date}', [ClaseController::class, 'getBlocks']);
    Route::get('/clases/{id}/json', [ClaseController::class, 'getJson']);
    Route::post('/clases/{id}/reserve', [ClaseController::class, 'reserve']);
    Route::get('/clases/fetch', [ClaseController::class, 'paginatedClases']);

    //planes
    Route::get('/plans', [PlanController::class, 'index'])->name('user.planes.index');
    Route::get('/plans/active', [PlanController::class,'activePlan']);
    Route::get('/plans/historial', [PlanController::class,'historialPlans']);

    //videos
    Route::get('/videos', [VideoController::class, 'index'])->name('user.videos.index');
    Route::get('/videos/get', [VideoController::class, 'get']);
    //perfil
    Route::resource('profile', ProfileController::class);

  

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
