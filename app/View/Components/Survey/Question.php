<?php

namespace App\View\Components\Survey;

use App\Models\SurveyQuestion;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Question extends Component
{
    public function __construct(public SurveyQuestion $question)
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.survey.question');
    }
}
