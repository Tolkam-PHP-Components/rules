<?php

namespace Tolkam\Rules\Rule;

use InvalidArgumentException;
use Tolkam\Rules\Failures;
use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

/**
 * <code>
 * $input = [
 * 'a' => [
 * 'aa' => 'new \DateTime',
 * 'ab' => 500,
 * ],
 * 'b' => null,
 * 'c' => [
 * [
 * 'hash' => false
 * ],
 * [
 * 'hash' => null
 * ]
 * ]
 * ];
 *
 * $rulesArr = [
 * 'a' => new Rule\Arr([
 * 'aa' => new Rule\Type(\DateTime::class),
 * 'ab' => new Rule\NotEmpty(new Rule\Type('integer')),
 * 'ac' => new Rule\Arr([
 * 'aca' => new Rule\Type('array'),
 * ])
 * ]),
 * 'b' => new Rule\Sequence(
 * new Rule\NotEmpty,
 * new Rule\Choice(['x', 'y', 'z'])
 * ),
 * 'c' => new Rule\ArrayOf(
 * new Rule\Arr([
 * 'hash' => new Rule\Type('string'),
 * 'ip' => new Rule\Type('string')
 * ])
 * ),
 * 'd' => new Rule\NotEmpty
 * ];
 *
 * $rules = new Rule\Arr($rulesArr);
 * $result = $rules
 * ->apply($input)
 * ->flatten(new NamespacedCodesStrategy)
 * ->toArray();
 * </code>
 */
class Arr extends Rule
{
    /**
     * @var RuleInterface[]
     */
    protected array $rules = [];
    
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
        $failures = new Failures();
        
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
