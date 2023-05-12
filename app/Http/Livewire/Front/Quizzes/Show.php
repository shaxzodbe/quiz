<?php

namespace App\Http\Livewire\Front\Quizzes;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Show extends Component
{
    public Quiz $quiz;
    public Collection $questions;
    public Question $currentQuestion;
    public int $currentQuestionIndex = 0;
    public array $questionAnswers = [];
    public int $startTimeSeconds = 0;
    public function render()
    {
        return view('livewire.front.quizzes.show');
    }
    public function mount(): void
    {
        $this->startTimeSeconds = now()->timestamp;
        $this->questions = Question::query()
            ->inRandomOrder()
            ->whereRelation('quizzes','id', $this->quiz->id)
            ->with('questionOptions')
            ->get();
        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        for($i = 0; $i < $this->questionsCount; $i++) {
            $this->questionsAnswers[$i] = [];
        }
    }
    public function getQuestionsCountProperty(): int
    {
        return $this->questions->count();
    }
    public function changeQuestion(): void
    {
        $this->currentQuestionIndex++;

        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
    }
    public function submit()
    {
        dd('submit');
    }
}
