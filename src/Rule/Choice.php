<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;

class Choice extends Rule
{
    /**
     * values
     * @var array
     */
    protected $values = [];

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        if (!in_array($value, $this->values, true)) {
            return $this->failure('value.choice.invalid', 'Value must be one of allowed choices');
        }
        
        return null;
    }
}
