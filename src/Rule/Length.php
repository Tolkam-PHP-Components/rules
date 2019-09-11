<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\OptionsAwareRule;

class Length extends OptionsAwareRule
{
    /**
     * @inheritDoc
     */
    public function getKnownOptions(): array
    {
        return ['min', 'max', 'exact'];
    }

    /**
     * @inheritDoc
     */
    public function getDefaultOption(): string
    {
        return 'exact';
    }

    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        if ($failure = (new Type('string'))->apply($value)) {
            return $failure;
        }

        $failure = null;
        $length = mb_strlen($value);
        $min = $this->options['min'] ?? null;
        $max = $this->options['max'] ?? null;
        $exact = $this->options['exact'] ?? null;
        $hasMin = isset($min);
        $hasMax = isset($max);

        if ($exact) {
            if ($length !== $exact) {
                $failure = [
                    sprintf('value.length.invalid:%s', $exact),
                    sprintf('Value should be %s characters long', $exact)
                ];
            }
        } elseif ($hasMin && $hasMax) {
            if ($length < $min || $length > $max) {
                $failure = [
                    sprintf('value.length.invalidRange:%s:%s', $min, $max),
                    sprintf('Value length should be between %s and %s characters', $min, $max)
                ];
            }
        } elseif ($hasMin) {
            if ($length < $min) {
                $failure = [
                    sprintf('value.length.tooShort:%s', $min),
                    sprintf('Value length should be %s characters or more', $min)
                ];
            }
        } elseif ($hasMax) {
            if ($length > $max) {
                $failure = [
                    sprintf('value.length.tooLong:%s', $max),
                    sprintf('Value length should be %s characters or less', $max)
                ];
            }
        }

        return $failure ? $this->failure(...$failure) : $failure;
    }
}