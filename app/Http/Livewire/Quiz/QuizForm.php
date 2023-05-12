<?php

namespace App\Http\Livewire\Quiz;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Livewire\Component;

class QuizForm extends Component
{
    public Quiz $quiz;
    public bool $editing = false;
    public array $listForFields = [];
    public array $questions = [];

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz;
        $this->initListForFields();
        if ($this->quiz->exists) {
            $this->editing = true;
        } else {
            $this->quiz->published = false;
            $this->quiz->public = false;
        }
    }

    public function updatedQuizTitle(): void
    {
        $this->quiz->slug = Str::slug($this->quiz->title);
    }

    public function save(): Redirector
    {
        $this->validate();
        $this->quiz->save();
        return to_route('quizzes');
    }

    public function render()
    {
        return view('livewire.quiz.quiz-form');
    }

    public function rules(): array
    {
        return [
            'quiz.title' => [
                'string',
                'required'
            ],
            'quiz.slug' => [
                'string',
                'nullable'
            ],
            'quiz.description' => [
                'string',
                'nullable'
            ],
            'quiz.published' => [
                'boolean',
            ],
            'quiz.public' => [
                'boolean',
            ],
        ];
    }

    public function initListForFields(): void
    {
        $this->listForFields['questions'] = Question::pluck('question_text', 'id')->toArray();
    }
}
