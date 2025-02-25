<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\Resume;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

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

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'institute'], function () {
    Route::any('/', [InstituteController::class, 'index'])->name('institute.index')->middleware('auth');
    Route::get('/data', [InstituteController::class, 'data'])->name('institute.data');
    Route::delete('/delete', [InstituteController::class, 'delete'])->name('institute.delete');
    Route::any('/add', [InstituteController::class, 'add'])->name('institute.add');
    Route::any('/create', [InstituteController::class, 'create'])->name('institute.create');
});

Route::group(['prefix' => 'resume'], function () {
    Route::any('/', [ResumeController::class, 'index'])->name('resume.index')->middleware('auth');
    Route::get('/data', [ResumeController::class, 'data'])->name('resume.data');
    Route::delete('/delete', [ResumeController::class, 'delete'])->name('resume.delete');
    // Route::any('/resume/create', [ResumeController::class, 'create'])->name('resume.create');
    Route::any('/add_resume/{id}', [ResumeController::class, 'add_resume'])->name('resume.add_resume');
    Route::any('/add_sample/{id}', [ResumeController::class, 'add_sample'])->name('resume.add_sample');
    Route::any('/list_resume/{id}', [ResumeController::class, 'list_resume'])->name('resume.list_resume');
    Route::get('/getDataResume/{id}', [ResumeController::class, 'getDataResume'])->name('resume.getDataResume');
});

Route::group(['prefix' => 'coa'], function () {
    Route::any('/regulation', [CoaController::class, 'index'])->name('coa.regulation.index')->middleware('auth');
    Route::get('/data_regulation', [CoaController::class, 'data_regulation'])->name('coa.regulation.data_regulation');
    Route::delete('/regulation/delete_regulation', [CoaController::class, 'delete_regulation'])->name('coa.regulation.delete_regulation');
    Route::any('/regulation/update/{id}', [CoaController::class, 'edit_regulation'])->name('coa.regulation.update');
    // Route::any('/regulation/edit_regulation/{id}', [CoaController::class, 'edit_regulation'])->name('coa.regulation.edit');

    //parameter
    Route::any('/parameter', [CoaController::class, 'parameter'])->name('coa.parameter.index')->middleware('auth');
    Route::any('/parameter/add_parameter', [CoaController::class, 'add_parameter'])->name('parameter.add_parameter');
    Route::get('/data_parameter', [CoaController::class, 'data_parameter'])->name('coa.parameter.data_parameter');
    Route::any('/parameter/edit_parameter/{id}', [CoaController::class, 'edit_parameter'])->name('coa.parameter.edit');

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//PDF
Route::get('/generate-pdf/{customerId}', [PDFController::class, 'generatePdf'])->name('generate.pdf');
Route::get('/preview-pdf/{customerId}', [PDFController::class, 'previewPdf'])->name('preview.pdf');


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
