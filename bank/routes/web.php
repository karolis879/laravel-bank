<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountController as R;
use App\Http\Controllers\HolderController as H;
use App\Http\Controllers\TransfersController as T;
use App\Http\Controllers\StatisticsController as S;


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

Route::prefix('bank')->name('bank-')->group(function () {

    Route::get('/', [R::class, 'index'])->name('index'); // GET /bank from URL:  bank Name: bank-index
    Route::get('/create', [R::class, 'create'])->name('create'); // GET /bank/create from URL:  bank/create Name: bank-create
    Route::post('/', [R::class, 'store'])->name('store'); // POST /bank from URL:  bank Name: bank-store
    Route::get('/delete/{account}', [R::class, 'delete'])->name('delete'); // GET /bank/delete/{bank} from URL:  bank/delete/{bank} Name: bank-delete
    Route::delete('/{account}', [R::class, 'destroy'])->name('destroy'); // DELETE /bank/{bank} from URL:  bank/{bank} Name: bank-destroy 
    Route::get('/edit/{account}', [R::class, 'edit'])->name('edit'); // GET /bank/edit/{bank} from URL:  bank/edit/{bank} Name: bank-edit
    Route::put('/{account}', [R::class, 'update'])->name('update'); // PUT /bank/{bank} from URL:  bank/{bank} Name: bank-update

    // Route::get('/transfer', [R::class, 'transfer'])->name('transfer');
    // Route::post('/transferFunds', [R::class, 'transferFunds'])->name('transferFunds');

    Route::get('/transfers', [T::class, 'transfer'])->name('transfers');
    Route::post('/execute', [T::class, 'execute'])->name('execute');
});

Route::prefix('holders')->name('holders-')->group(function () {

    Route::get('/', [H::class, 'index'])->name('index');
    Route::get('/create', [H::class, 'create'])->name('create');
    Route::post('/', [H::class, 'store'])->name('store');
    Route::get('/delete/{holder}', [H::class, 'delete'])->name('delete');
    Route::delete('/{holder}', [H::class, 'destroy'])->name('destroy');
    Route::get('/edit/{holder}', [H::class, 'edit'])->name('edit');
    Route::put('/{holder}', [H::class, 'update'])->name('update');

    Route::get('preview/{holder}', [H::class, 'preview'])->name('preview');
});

Route::get('/statistics', [S::class, 'index'])->name('statistics');
Route::get('/', [S::class, 'index'])->name('statistics');




Auth::routes(['register' => false]);

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
