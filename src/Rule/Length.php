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
                    'invalid',
                    sprintf('Should be %s characters long', $exact),
                    compact('exact'),
                ];
            }
        }
        elseif ($hasMin && $hasMax) {
            if ($length < $min || $length > $max) {
                $failure = [
                    'invalid.range',
                    sprintf('Length should be between %s and %s characters', $min, $max),
                    compact('min', 'max'),
                ];
            }
        }
        elseif ($hasMin) {
            if ($length < $min) {
                $failure = [
                    'invalid.short',
                    sprintf('Length should be %s characters or more', $min),
                    compact('min'),
                ];
            }
        }
        elseif ($hasMax) {
            if ($length > $max) {
                $failure = [
                    'invalid.long',
                    sprintf('Length should be %s characters or less', $max),
                    compact('max'),
                ];
            }
        }
        
        return $failure ? $this->failure(...$failure) : $failure;
    }
}
