<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Quiz\QuizList;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('quiz/{quiz}/{slug?}', [\App\Http\Controllers\HomeController::class, 'show'])->name('quiz.show');

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('isAdmin')->group(function () {
        Route::get('questions', \App\Http\Livewire\Questions\QuestionList::class)->name('questions');
        Route::get('questions/create', \App\Http\Livewire\Questions\QuestionForm::class)->name('questions.create');
        Route::get('questions/{question}', \App\Http\Livewire\Questions\QuestionForm::class)->name('questions.edit');

        Route::get('quizzes', QuizList::class)->name('quizzes');
        Route::get('quiz/create', \App\Http\Livewire\Quiz\QuizForm::class)->name('quiz.create');
        Route::get('quiz/{quiz}', \App\Http\Livewire\Quiz\QuizForm::class)->name('quiz.edit');
    });
});

require __DIR__.'/auth.php';
