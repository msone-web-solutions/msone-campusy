@props(['question', 'correct', 'correctAnswer'])

@php use App\Support\Markdown; @endphp

@if ($correct)
    <div class="rq-callout rq-callout--green"><i class="bx bx-check-circle"></i><div><h4>Richtig!</h4>@if ($question->explanation)<p>{!! Markdown::inline($question->explanation) !!}</p>@endif</div></div>
@else
    <div class="rq-callout rq-callout--red"><i class="bx bx-x-circle"></i><div><h4>Leider falsch. Richtig wäre: {!! Markdown::inline($correctAnswer) !!}</h4>@if ($question->explanation)<p>{!! Markdown::inline($question->explanation) !!}</p>@endif</div></div>
@endif
