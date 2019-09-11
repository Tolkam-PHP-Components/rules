<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class Sequence extends Rule
{
    /**
     * rules
     * @var RuleInterface
     */
    protected $rules = [];

    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        foreach ($this->rules as $k => $rule) {
            if ($failure = $rule->apply($value)) {
                return $failure;
            }
        }
        
        return null;
    }
}
