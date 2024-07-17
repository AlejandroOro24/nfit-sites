<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Plans\PlanController;
use App\Http\Controllers\Videos\VideoController;
use App\Http\Controllers\publicWeb\TrialController;
use App\Http\Controllers\users\DashboardController;
use App\Http\Controllers\users\clases\ClaseController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\publicWeb\LoginAndBuyController;
use App\Http\Controllers\users\profile\ProfileController;
use App\Http\Controllers\publicWeb\RegisterAndBuyController;
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
    
    //CLase de prueba
    Route::get('/trial/{id}', [TrialController::class, 'TestReservationRegister'])->name('registerTrial.index');
    Route::post('/trial/register/{clase}', [TrialController::class, 'registerTrial'])->name('registerTrial.store');
    Route::get('/trial/ready/{clase}', [TrialController::class, 'reservationReady'])->name('registerTrial.ready');

    //Solicitud de plan y Registro de usuario
    Route::get('/registerAndBuy/{id}', [RegisterAndBuyController::class, 'index'])->name('registerAndBuy.index');
    Route::post('/registerAndBuy/store/{id}', [RegisterAndBuyController::class, 'store'])->name('registerAndBuy.store');
    Route::get('/registerAndBuy/pay/{id}', [RegisterAndBuyController::class, 'pay'])->name('registerAndBuy.pay');

    //Solicitud de plan y Login
    Route::get('/loginAndBuy/{id}', [LoginAndBuyController::class, 'index'])->name('loginAndBuy.index');
    Route::post('/loginAndBuy/store/{id}', [LoginAndBuyController::class, 'store'])->name('loginAndBuy.store');
    Route::get('/loginAndBuy/pay/{id}', [LoginAndBuyController::class, 'pay'])->name('loginAndBuy.pay');

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    //clases
    Route::get('/clases', [ClaseController::class, 'index'])->name('user.clases.index');
    Route::get('/clases/types' , [ClaseController::class, 'getTypes'] );
    Route::get('/clases/week/{clase}', [ClaseController::class, 'getWeek']);
    Route::get('/clases/blocks/{date}', [ClaseController::class, 'getBlocks']);
    Route::get('/clases/{id}/json', [ClaseController::class, 'getJson']);
    Route::post('/clases/{id}/reserve', [ClaseController::class, 'reserve']);
    Route::get('/clases/{id}/confirm' , [ClaseController::class, 'confirm']);
    Route::get('/clases/{id}/dismiss' , [ClaseController::class, 'dismiss']);
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
