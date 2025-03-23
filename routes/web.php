<?php

use App\Http\Controllers\AmbientAirController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DirectorController;
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
    return view('welcome');
})->name('index');

Route::resource('director', DirectorController::class);

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'customer'], function () {
    Route::any('/', [CustomerController::class, 'index'])->name('customer.index')->middleware('auth');
    Route::get('/data', [CustomerController::class, 'data'])->name('customer.data');
    Route::delete('/delete', [CustomerController::class, 'delete'])->name('delete');
    Route::any('/add', [CustomerController::class, 'add'])->name('customer.add');
    Route::any('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
});

Route::group(['prefix' => 'institute'], function () {
    Route::any('/', [InstituteController::class, 'index'])->name('institute.index')->middleware('auth');
    Route::get('/data', [InstituteController::class, 'data'])->name('institute.data');
    Route::delete('/delete', [InstituteController::class, 'delete'])->name('institute.delete');
    Route::any('/create', [InstituteController::class, 'create'])->name('institute.create');
    Route::any('/edit/{id}', [InstituteController::class, 'edit'])->name('institute.edit');
    Route::get('/get_regulation_by_subject_ids', [InstituteController::class, 'getRegulationBySubjectIds'])->name('DOC.get_regulation_id_by_id');
});

Route::group(['prefix' => 'result'], function () {
    Route::any('/', [ResultController::class, 'index'])->name('result.index')->middleware('auth');
    Route::get('/data', [ResultController::class, 'data'])->name('result.data');
    Route::delete('/delete', [ResultController::class, 'delete'])->name('result.delete');
    Route::any('/noise/{id}', [ResultController::class, 'addNoise'])->name('result.noise.add');
    Route::any('/noise_new/{id}', [ResultController::class, 'addNoiseNew'])->name('result.noise.add_new');
    Route::any('/workplace_air/{id}', [ResultController::class, 'addWorkplaceAir'])->name('result.workplace.add');
    Route::any('/odor/{id}', [ResultController::class, 'addOdor'])->name('result.odor.add');
    Route::any('/illumination/{id}', [ResultController::class, 'addIllumination'])->name('result.illumination.add');
    Route::any('/heat_stress/{id}', [ResultController::class, 'addHeatStress'])->name('result.heat_stress.add');
    Route::any('/stationary_stack/{id}', [ResultController::class, 'addStationaryStack'])->name('result.stationary_stack.add');
    Route::any('/add_result/{id}', [ResultController::class, 'add_result'])->name('result.add_result');
    Route::any('/add_sample/{id}', [ResultController::class, 'add_sample'])->name('result.add_sample');
    Route::any('/add_sample_new/{id}', [ResultController::class, 'add_sample_new'])->name('result.add_sample_new');
    Route::any('/list_result/{id}', [ResultController::class, 'list_result'])->name('result.list_result');
    Route::get('/getDataResult/{id}', [ResultController::class, 'getDataResult'])->name('result.getDataResult');

    // ---------------------------------------------------------------------------------------------------------------------------------------

    Route::any('/add_sample_1/{id}', [AmbientAirController::class, 'add_sample_1'])->name('result.add_sample_1');
    Route::any('/ambient_air/{id}', [AmbientAirController::class, 'addAmbientAir_1'])->name('result.ambient_air.add_1');
    Route::any('/add_sample_2/{id}', [AmbientAirController::class, 'add_sample_2'])->name('result.add_sample_2');
    Route::any('/ambient_air_2/{id}', [AmbientAirController::class, 'addAmbientAir_2'])->name('result.ambient_air.add_2');
    Route::any('/add_sample_3/{id}', [AmbientAirController::class, 'add_sample_3'])->name('result.add_sample_3');
    Route::any('/ambient_air_3/{id}', [AmbientAirController::class, 'addAmbientAir_3'])->name('result.ambient_air.add_3');
    Route::any('/add_sample_4/{id}', [AmbientAirController::class, 'add_sample_4'])->name('result.add_sample_4');
    Route::any('/ambient_air_4/{id}', [AmbientAirController::class, 'addAmbientAir_4'])->name('result.ambient_air.add_4');
    Route::any('/add_sample_5/{id}', [AmbientAirController::class, 'add_sample_5'])->name('result.add_sample_5');
    Route::any('/ambient_air_5/{id}', [AmbientAirController::class, 'addAmbientAir_5'])->name('result.ambient_air.add_5');
    Route::any('/add_sample_6/{id}', [AmbientAirController::class, 'add_sample_6'])->name('result.add_sample_6');
    Route::any('/ambient_air_6/{id}', [AmbientAirController::class, 'addAmbientAir_6'])->name('result.ambient_air.add_6');
    Route::any('/add_sample_7/{id}', [AmbientAirController::class, 'add_sample_7'])->name('result.add_sample_7');
    Route::any('/ambient_air_7/{id}', [AmbientAirController::class, 'addAmbientAir_7'])->name('result.ambient_air.add_7');
    Route::any('/add_sample_8/{id}', [AmbientAirController::class, 'add_sample_8'])->name('result.add_sample_8');
    Route::any('/ambient_air_8/{id}', [AmbientAirController::class, 'addAmbientAir_8'])->name('result.ambient_air.add_8');
    Route::any('/add_sample_9/{id}', [AmbientAirController::class, 'add_sample_9'])->name('result.add_sample_9');
    Route::any('/ambient_air_9/{id}', [AmbientAirController::class, 'addAmbientAir_9'])->name('result.ambient_air.add_9');
    Route::any('/add_sample_10/{id}', [AmbientAirController::class, 'add_sample_10'])->name('result.add_sample_10');
    Route::any('/ambient_air_10/{id}', [AmbientAirController::class, 'addAmbientAir_10'])->name('result.ambient_air.add_10');
});

Route::group(['prefix' => 'manage_coa'], function () {
    Route::group(['prefix' => 'coa'], function () {
        
        //subject
        Route::get('/subject', [CoaController::class, 'subject'])->name('coa.subject.index')->middleware('auth');
        Route::get('/data_subject', [CoaController::class, 'data_subject'])->name('coa.subject.data_subject');
        Route::post('/subject', [CoaController::class, 'create_subject'])->name('coa.subject.store');
        Route::any('/subject/{id}/update', [CoaController::class, 'edit_subject'])->name('coa.subject.update');
        Route::delete('/subject/delete_subject', [CoaController::class, 'delete_subject'])->name('coa.subject.delete_subject');
        
        //regulation
        Route::any('/regulation', [CoaController::class, 'index'])->name('coa.regulation.index')->middleware('auth');
        Route::get('/data_regulation', [CoaController::class, 'data_regulation'])->name('coa.regulation.data_regulation');
        Route::any('/regulation/update/{id}', [CoaController::class, 'edit_regulation'])->name('coa.regulation.update');
        Route::delete('/regulation/delete_regulation', [CoaController::class, 'delete_regulation'])->name('coa.regulation.delete_regulation');
        
        //parameter
        Route::any('/parameter', [CoaController::class, 'parameter'])->name('coa.parameter.index')->middleware('auth');
        Route::any('/parameter/add_parameter', [CoaController::class, 'add_parameter'])->name('parameter.add_parameter');
        Route::get('/data_parameter', [CoaController::class, 'data_parameter'])->name('coa.parameter.data_parameter');
        Route::any('/parameter/edit_parameter/{id}', [CoaController::class, 'edit_parameter'])->name('coa.parameter.edit');
        Route::delete('/parameter/delete_parameter', [CoaController::class, 'delete_parameter'])->name('coa.parameter.delete_parameter');

        //sampling_time
        Route::any('/sampling_time', [CoaController::class, 'sampling_time'])->name('coa.sampling_time.index')->middleware('auth');
        Route::get('/data_sampling_time', [CoaController::class, 'data_sampling_time'])->name('coa.sampling_time.data_sampling_time');
        Route::any('/sampling_time/update/{id}', [CoaController::class, 'edit_sampling_time'])->name('coa.sampling_time.update');
        Route::delete('/sampling_time/delete_sampling_time', [CoaController::class, 'delete_sampling_time'])->name('coa.sampling_time.delete_sampling_time');

        //regulation_standard
        Route::any('/regulation_standard', [CoaController::class, 'regulation_standard'])->name('coa.regulation_standard.index')->middleware('auth');
        Route::get('/data_regulation_standard', [CoaController::class, 'data_regulation_standard'])->name('coa.regulation_standard.data_regulation_standard');
        Route::any('/regulation_standard/update/{id}', [CoaController::class, 'edit_regulation_standard'])->name('coa.regulation_standard.update');
        Route::delete('/regulation_standard/delete_regulation_standard', [CoaController::class, 'delete_regulation_standard'])->name('coa.regulation_standard.delete_regulation_standard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//PDF
Route::get('/resume_coa/{customerId}', [PDFController::class, 'previewPdf'])->name('preview.pdf');
Route::get('/ambient_air/{customerId}', [PDFController::class, 'ambientAirPdf'])->name('ambient.air.pdf');


Route::get('/directors', [DirectorController::class, 'index'])->name('director.index');
Route::put('/directors/{id}/edit', [DirectorController::class, 'edit'])->name('director.edit');



Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware(['can:log-viewers.read']);

Route::group(['prefix' => 'setting','middleware' => ['auth']],function () {
    Route::group(['prefix' => 'manage_account'], function () {
        Route::group(['prefix' => 'users'], function () { //route to manage users
            Route::any('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/data', [UserController::class, 'data'])->name('users.data');
            Route::any('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::any('/reset_password/{id}', [UserController::class, 'reset_password'])->name('users.reset_password');
            Route::delete('/delete', [UserController::class, 'delete'])->name('users.delete');
        });
        Route::group(['prefix' => 'roles'], function () { //route to manage roles
            Route::any('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/data', [RoleController::class, 'data'])->name('roles.data');
            Route::any('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::delete('/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');
        });
        Route::group(['prefix' => 'permissions'], function () { //route to manage permissions
            Route::any('/', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/data', [PermissionController::class, 'data'])->name('permissions.data');
            Route::get('/view/{id}', [PermissionController::class, 'view'])->name('permissions.view');
            Route::get('/view/{id}/users', [PermissionController::class, 'view_users_data'])->name('permissions.view_users_data');
            Route::get('/view/{id}/roles', [PermissionController::class, 'view_roles_data'])->name('permissions.view_roles_data');
        });
    });
});
