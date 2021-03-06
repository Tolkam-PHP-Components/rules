<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;

class IsEmpty extends Rule
{
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        if (!empty($value)) {
            return $this->failure('isEmpty', 'Value must be empty');
        }
        
        return null;
    }
}
