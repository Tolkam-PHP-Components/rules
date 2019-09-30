<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

/**
 * Sequence of rules, stops on first failure
 */
class Sequence extends Rule
{
    /**
     * rules
     *
     * @var RuleInterface
     */
    protected $rules = [];
    
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(RuleInterface ...$rules)
    {
        if (!empty($rules)) {
            $this->rules = $rules;
        }
    }
    
    /**
     * Adds to sequence
     *
     * @param RuleInterface $rule
     */
    public function add(RuleInterface $rule)
    {
        $this->rules[] = $rule;
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
