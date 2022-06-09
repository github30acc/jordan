<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudCOntroller;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CrudCOntroller::class, 'index']);
Route::post('insert_application', [CrudCOntroller::class, 'insert']);
Route::post('select_application', [CrudCOntroller::class, 'select']);
Route::post('update_application', [CrudCOntroller::class, 'update']);
Route::post('delete_application', [CrudCOntroller::class, 'delete']);


// Route::get('/', function () {
//     return view('welcome');
// });
