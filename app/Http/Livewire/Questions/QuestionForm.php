<?php

namespace App\Http\Livewire\Questions;

use App\Models\Question;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class QuestionForm extends Component
{
    public Question $question;
    public bool $editing = false;
    public array $questionOptions = [];

    public function mount(Question $question): void
    {
        $this->question = $question;
        if ($this->question->exists) {
            $this->editing = true;
            foreach ($this->question->questionOptions() as $option) {
                $this->questionOptions[] = [
                    'id' => $option->id,
                    'option' => $option->option,
                    'question_id' => $option->question_id
                ];
            }
        }
    }

    public function addQuestionOption(): void
    {
        $this->questionOptions[] = [
            'option' => '',
            'correct' => false
        ];
    }

    public function removeQuestionOption(int $index): void
    {
        unset($this->questionOptions[$index]);
        $this->questionOptions = array_values($this->questionOptions);
    }

    public function save(): Redirector
    {
        $this->validate();
        $this->question->save();
        $this->question->questionOptions()->delete();
        foreach ($this->questionOptions as $option) {
            $this->question->questionOptions()->create($option);
        }
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
            ],
            'questionOptions' => [
                'required',
                'array'
            ],
            'questionOptions.*.option' => [
                'required',
                'string'
            ]
        ];
    }
}
