<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class EmptyOr extends Rule
{
    /**
     * @param RuleInterface $nextRule
     */
    public function __construct(RuleInterface $nextRule)
    {
        $this->setNextRule($nextRule);
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        return !empty($value) ? $this->next()->apply($value) : null;
    }
}
