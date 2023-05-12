<?php

namespace App\Http\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class QuizList extends Component
{
    public function render()
    {
        $quizzes = Quiz::latest()->paginate();
        return view('livewire.quiz.quiz-list', compact('quizzes'));
    }

    public function delete(Quiz $quiz): void
    {
        abort_if(! auth()->user()->is_admin,
            Response::HTTP_FORBIDDEN,
            '403 Forbidden'
        );
    }
}
