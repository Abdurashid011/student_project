<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentSubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'index']);

Route::resource('student', StudentController::class);

Route::delete('/subject/delete/{student_id}/{subject_id}', [StudentSubjectController::class, 'destroy'])->name('subject.delete');
Route::post('/subject/create/{student_id}', [StudentSubjectController::class, 'store'])->name('subject.create');

Route::get('/search', [StudentController::class, 'search'])->name('search');
