<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/students', [StudentController::class, 'index']);

Route::get('/students/{id}', function () {
    return 'obteniend estudiante';
});

Route::post('/students', [StudentController::class, 'store']);

Route::put('/students/{id}', function () {
    return 'Actualizando estudiantees';
});

Route::delete('/students/{id}', function () {
    return 'ELiminando estudiantes';
});


