<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class EmptyOr extends Rule
{
    /**
     * @var RuleInterface
     */
    protected $nextRule;
    
    /**
     * @param RuleInterface $nextRule
     */
    public function __construct(RuleInterface $nextRule)
    {
        $this->nextRule = $nextRule;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        return !empty($value) ? $this->nextRule->apply($value) : null;
    }
}
