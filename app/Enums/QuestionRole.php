<?php

namespace App\Enums;

enum QuestionRole: string
{
    /** Part of the end-of-topic test and of the spaced review pool. */
    case Test = 'test';

    /** Inline check inside the explanation ("Jetzt du"). */
    case Check = 'check';
}
