<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class NotEmpty extends Rule
{
    /**
     * @param RuleInterface|null $nextRule
     */
    public function __construct(RuleInterface $nextRule = null)
    {
        $this->setNextRule($nextRule);
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        if (empty($value)) {
            return $this->failure('notEmpty', 'Value must not be empty');
        }
        
        if ($next = $this->next()) {
            return $next->apply($value);
        }
        
        return null;
    }
}
