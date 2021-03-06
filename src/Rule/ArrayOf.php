<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Failures;
use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

/**
 * Applies the rule to each element of the array
 */
class ArrayOf extends Rule
{
    /**
     * @var RuleInterface
     */
    protected $rule;
    
    /**
     * @param RuleInterface $rule
     */
    public function __construct(RuleInterface $rule)
    {
        $this->rule = $rule;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        // value must be array
        if ($failure = (new Type('array'))->apply($value)) {
            return $failure;
        }
        
        $failures = new Failures();
        
        foreach ($value as $k => $v) {
            if ($failure = $this->rule->apply($v)) {
                $failures[$k] = $failure;
            }
        }
        
        return $failures->count() ? $failures : null;
    }
}
