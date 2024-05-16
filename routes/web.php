<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\FolderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadFileController;

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

Route::get('/', function () {
    // return redirect("home");
    return view("welcome");
});

Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get("/access-denie", function(){
    return view("errors.accessDenie");
});
Route::group(['prefix' => 'api', 'middleware' => ['auth']], function () {
    Route::post('/user/dashboard2', [HomeController::class, 'dashboard']);
    Route::post('/deconnexion', [HomeController::class, 'deconnexion']);
    Route::post('/store-user', [UserController::class, 'storeUser']);
    Route::post('/update-user', [UserController::class, 'updateUser']);
    Route::post('/update-credentials', [UserController::class, 'updateCredentials']);
    Route::post('/store-cities-data', [CityController::class, 'storeCities']);
    Route::post ("/get-cities", [CityController::class, 'getCities']);
    Route::get("/get-users", [UserController::class, 'getUsers']);
    Route::get("/get-roles", [UserController::class, "getRoles"]);
    Route::post('/delete-user', [UserController:: class, 'softDelete']);
    Route::post('/store-role', [UserController::class, "storeRole"]);
    Route::post('/update-role', [UserController::class, 'updateRole']);
    Route::post('/delete-role', [UserController:: class, 'softDeleteRole']);
    Route::get("/get-list-adhesion", [UserController::class, 'adhesionList']);
    Route::Post("/migrate-from-adhto-user", [UserController::class, 'migrationProcesssing']);

    Route::get('/get-contribution/{year}', [ContributionController::class, 'getContribution']);
    Route::post('/get-contribution-for-user', [ContributionController::class, 'getContribForUser']);

    Route::POST('/update-one-contribution', [ContributionController::class, 'updateOneContribution']);
    Route::POST('/search-contribution', [ContributionController::class, 'searchContribution']);
    Route::post("/get-total-per-year",[ContributionController::class, 'getTotalPerYear']);
    Route::post("/upload-files",[UploadFileController::class, 'uploadFile']);
    Route::post("get-files", [UploadFileController::class, 'getFiles']);

    Route::post("/create-new-folder", [FolderController::class, 'createFolder']);
    Route::post("/get-folders", [FolderController::class, 'getFolders']);
    Route::post("/delete-folder", [FolderController::class, 'deleteFolder']);
    Route::post("/rename-folder", [FolderController::class, 'renameFolder']);
    Route::post("/get-files-of-folder", [FolderController::class, 'getFiles']);
    Route::post("/add-file", [FolderController::class, 'addFile']);
    Route::post("/share-file", [FolderController::class, 'shareFile']);

});

Route::get('/load-data-from-wikipedia', [HomeController::class, 'loadData']);