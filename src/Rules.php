<?php

namespace Tolkam\Rules;

use InvalidArgumentException;

/**
 * Set of other rules
 */
class Rules extends Rule
{
    /**
     * @var RuleInterface[]
     */
    protected $rules = [];
    
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(array $rules)
    {
        $this->extend($rules);
    }
    
    /**
     * Extends the set with new rules
     *
     * @param array $rules
     *
     * @return self
     */
    public function extend(array $rules)
    {
        foreach ($rules as $key => $rule) {
            $this->add($key, $rule);
        }
        
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        $failures = new RuleFailures();
        
        foreach ($this->rules as $k => $rule) {
            $v = is_array($value) ? ($value[$k] ?? null) : $value;
            
            if ($result = $rule->apply($v)) {
                $failures[$k] = $result;
            }
        }
        
        return count($failures) ? $failures : null;
    }
    
    /**
     * Adds a rule
     *
     * @param string        $key
     * @param RuleInterface $rule
     *
     * @return self
     */
    protected function add(string $key, RuleInterface $rule)
    {
        if (isset($this->rules[$key])) {
            throw new InvalidArgumentException(sprintf('Rule with key "%s" is already exists', $key));
        }
        
        $this->rules[$key] = $rule;
        
        return $this;
    }
}
