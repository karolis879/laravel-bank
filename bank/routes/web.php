<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccountController as R;

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

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
