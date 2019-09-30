<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;

class Email extends Rule
{
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        if (! is_string($value)
            || ! mb_check_encoding($value, 'ASCII')
            || ! filter_var($value, FILTER_VALIDATE_EMAIL)
        ) {
            return $this->failure('invalid', 'Invalid email');
        }
        
        return null;
    }
}
