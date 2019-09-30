<?php

namespace Tolkam\Rules\Rule;

use InvalidArgumentException;
use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleFailures;
use Tolkam\Rules\RuleInterface;

class Set extends Rule
{
    /**
     * @var RuleInterface[]
     */
    protected $rules = [];

    /**
     * @param RuleInterface[] $definition
     */
    public function __construct(array $definition)
    {
        $this->extend($definition);
    }
    
    /**
     * Extends the set with new rules
     *
     * @param array $definition
     *
     * @return self
     */
    public function extend(array $definition)
    {
        foreach ($definition as $key => $rule) {
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
            do {
                if ($result = $rule->apply($v)) {
                    $failures[$k] = $result;
                    break;
                }
            } while ($rule = $rule->next());
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
        if(isset($this->rules[$key])) {
            throw new InvalidArgumentException(sprintf('Rule with key "%s" is already exists in set', $key));
        }
        
        $this->rules[$key] = $rule;
        return $this;
    }
}
