<?php

namespace App\Http\Livewire\Questions;

use App\Models\Question;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class QuestionForm extends Component
{
    public Question $question;
    public bool $editing = false;

    public function mount(Question $question): void
    {
        $this->question = $question;
        if ($this->question->exists) {
            $this->editing = true;
        }
    }

    public function save(): Redirector
    {
        $this->validate();
        $this->question->save();
        return to_route('questions');
    }
    public function render()
    {
        return view('livewire.questions.question-form');
    }

    public function rules(): array
    {
        return [
            'question.question_text' => [
                'string',
                'required'
            ],
            'question.code_snippet' => [
                'string',
                'nullable'
            ],
            'question.answer_explanation' => [
                'string',
                'nullable'
            ],
            'question.more_info_link' => [
                'url',
                'nullable'
            ]
        ];
    }
}
