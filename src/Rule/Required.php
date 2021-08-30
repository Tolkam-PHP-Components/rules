<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class Required extends Rule
{
    /**
     * @var RuleInterface|null
     */
    protected $nextRule;
    
    /**
     * @param RuleInterface|null $nextRule
     */
    public function __construct(RuleInterface $nextRule = null)
    {
        $this->nextRule = $nextRule;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        if ($value === null) {
            return $this->failure('required', 'Value is required');
        }
        
        return $this->nextRule
            ? $this->nextRule->apply($value)
            : $this->nextRule;
    }
}
