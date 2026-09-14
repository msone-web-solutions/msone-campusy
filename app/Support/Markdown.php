<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Renders the (trusted, file-based) lesson content to HTML.
 */
class Markdown
{
    public static function block(?string $markdown): HtmlString
    {
        return new HtmlString(Str::markdown($markdown ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]));
    }

    public static function inline(?string $markdown): HtmlString
    {
        return new HtmlString(Str::inlineMarkdown($markdown ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]));
    }
}
