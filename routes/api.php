<?php

use App\Http\Controllers\Api\EmployeesResourceController;
use App\Http\Controllers\Api\EmployeesTreeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('tree', [EmployeesTreeController::class, 'index']);
Route::get('child/{id}', [EmployeesTreeController::class, 'getEmployee'])->name('tree.getEmployee');
Route::get('boss/{boss}/{employee}', [EmployeesTreeController::class, 'getBossSubs'])->name('tree-employees.get-boss-subs');
Route::get('dragEmployee/{boss}/{employee}', [EmployeesTreeController::class, 'getDragEmployee'])->name('tree.getDragEmployee');
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('employees/mainBoss/{boss}', [EmployeesResourceController::class, 'mainBoss'])->name('main-boss');
    Route::resources(['employees' => EmployeesResourceController::class,]);
});
