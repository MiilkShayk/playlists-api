<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\MusicasController;
use App\Http\Controllers\MusicaCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaylistsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



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

// Login(Auth)

//TEste 
Route::get('loginPage', [AuthController::class, 'loginPage'])->name('loginPage');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function () {
    // Rotas protegidas pelo middleware de autenticação JWT
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'getUser']);
});




// Users
Route::post('/user_create', [UserController::class, 'handle'])->defaults('action', 'create');
Route::get('/users', [UserController::class, 'read']);
Route::put('/user_update/{id}', [UserController::class, 'update']);
Route::delete('/user_delete/{id}', [UserController::class, 'delete']);




//Musicas
Route::post('/musica_create', [MusicasController::class, 'handle'])->defaults('action', 'create');
Route::get('/musicas', [MusicasController::class, 'handle'])->defaults('action', 'read');
Route::put('/musica_update/{id}', [MusicasController::class, 'update']);
Route::delete('/musica_delete/{id}', [MusicasController::class, 'delete']);




//MusicaCategory
Route::post('/musica_category_create', [MusicaCategoryController::class, 'handle'])->defaults('action', 'create');
Route::get('/musica_categories', [MusicaCategoryController::class, 'handle'])->defaults('action', 'read');
Route::put('/musica_category_update/{id}', [MusicaCategoryController::class, 'update']);
Route::delete('/musica_category_delete/{id}', [MusicaCategoryController::class, 'delete']);




//Author
Route::post('/author_create', [AuthorController::class, 'handle'])->defaults('action', 'create');
Route::get('/authors', [AuthorController::class, 'handle'])->defaults('action', 'read');
Route::put('/author_update/{id}', [AuthorController::class, 'update']);
Route::delete('/author_delete/{id}', [AuthorController::class, 'delete']);





Route::get('/playlists/{playlistId}/musicas', [PlaylistsController::class, 'showMusicasOnPlaylist']);
Route::post('/playlists/{playlist}/add-musicas', [PlaylistsController::class, 'addMusicas']);
Route::post('/playlist_create', [PlaylistsController::class, 'handle'])->defaults('action', 'create');
Route::get('/playlists', [PlaylistsController::class, 'handle'])->defaults('action', 'read');
Route::put('/playlist_update/{id}', [PlaylistsController::class, 'update']);
Route::delete('/playlist_delete/{id}', [PlaylistsController::class, 'delete']);
