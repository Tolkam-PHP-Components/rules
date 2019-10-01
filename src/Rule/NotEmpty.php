<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class NotEmpty extends Rule
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
        if (empty($value)) {
            return $this->failure('notEmpty', 'Value must not be empty');
        }
        
        return $this->nextRule
            ? $this->nextRule->apply($value)
            : $this->nextRule;
    }
}
