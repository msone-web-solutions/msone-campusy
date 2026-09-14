<?php

namespace App\Quiz;

/**
 * Turns what a student typed into a number. Accepts decimals with comma or
 * dot ("0,75" / "0.75"), fractions ("3/4", "-3/4"), mixed numbers ("1 1/2")
 * and the unicode minus sign.
 */
class NumericAnswerParser
{
    public function parse(mixed $input): ?float
    {
        if (is_int($input) || is_float($input)) {
            return (float) $input;
        }

        if (! is_string($input)) {
            return null;
        }

        $value = trim(str_replace(['−', '–', ' '], ['-', '-', ' '], $input));
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;

        if ($value === '') {
            return null;
        }

        // Mixed number: "1 1/2" or "-2 3/4"
        if (preg_match('/^(-?)(\d+) (\d+)\/(\d+)$/', $value, $m) === 1) {
            if ((int) $m[4] === 0) {
                return null;
            }
            $sign = $m[1] === '-' ? -1 : 1;

            return $sign * ((int) $m[2] + (int) $m[3] / (int) $m[4]);
        }

        // Plain fraction: "3/4", "-3/4", "3/-4"
        if (preg_match('/^(-?\d+(?:[.,]\d+)?)\/(-?\d+(?:[.,]\d+)?)$/', $value, $m) === 1) {
            $numerator = (float) str_replace(',', '.', $m[1]);
            $denominator = (float) str_replace(',', '.', $m[2]);

            return $denominator == 0.0 ? null : $numerator / $denominator;
        }

        // Decimal with comma or dot, optional thousands separators are not supported on purpose
        if (preg_match('/^-?\d+(?:[.,]\d+)?$/', $value) === 1) {
            return (float) str_replace(',', '.', $value);
        }

        return null;
    }
}
