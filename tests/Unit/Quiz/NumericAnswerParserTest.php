<?php

use App\Quiz\NumericAnswerParser;

$parser = new NumericAnswerParser;

it('parses decimals with comma and dot', function () use ($parser) {
    expect($parser->parse('0,75'))->toBe(0.75)
        ->and($parser->parse('0.75'))->toBe(0.75)
        ->and($parser->parse('-2,5'))->toBe(-2.5)
        ->and($parser->parse(' 12 '))->toBe(12.0);
});

it('parses fractions and mixed numbers', function () use ($parser) {
    expect($parser->parse('3/4'))->toBe(0.75)
        ->and($parser->parse('-3/4'))->toBe(-0.75)
        ->and($parser->parse('1 1/2'))->toBe(1.5)
        ->and($parser->parse('-2 1/4'))->toBe(-2.25);
});

it('accepts the unicode minus sign', function () use ($parser) {
    expect($parser->parse('−15'))->toBe(-15.0);
});

it('rejects garbage and division by zero', function () use ($parser) {
    expect($parser->parse('abc'))->toBeNull()
        ->and($parser->parse('3/0'))->toBeNull()
        ->and($parser->parse(''))->toBeNull()
        ->and($parser->parse(null))->toBeNull();
});
