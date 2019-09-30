<?php

namespace Tolkam\Rules;

/**
 * <code>
 * $input = [
 * 'a' => [
 * 'aa' => 'new \DateTime',
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
 * 'a' => new Rule\Set([
 * 'aa' => new Rule\Type(\DateTime::class),
 * 'ab' => new Rule\NotEmpty(new Rule\Type('integer')),
 * 'ac' => new Rule\Set([
 * 'aca' => new Rule\Type('array'),
 * ])
 * ]),
 * 'b' => new Rule\Sequence(
 * new Rule\NotEmpty,
 * new Rule\Choice(['x', 'y', 'z'])
 * ),
 * 'c' => new Rule\ArrayOf(
 * new Rule\Set([
 * 'hash' => new Rule\Type('string'),
 * 'ip' => new Rule\Type('string')
 * ])
 * ),
 * 'd' => new Rule\NotEmpty
 * ];
 *
 * $rule = new Rule\Set($rulesArr);
 *
 * $result = Validator::validate($rule, $input)->flatten();
 * </code>
 *
 * @deprecated
 */
class Validator
{
    /**
     * @inheritDoc
     */
    public static function validate(RuleInterface $rule, $value, string $name = null): RuleFailuresInterface
    {
        // trigger_error(sprintf(
        //     'Method %s is deprecated. Use %s::apply() instead',
        //     __METHOD__,
        //     Rules::class
        // ), E_USER_DEPRECATED);
    
        $failures = new RuleFailures();
    
        while ($rule) {
            if ($result = $rule->apply($value)) {
                switch (true) {
                    // rule failure
                    case($result instanceof RuleFailureInterface):
                        $key = $name !== null ? $name : 0;
                        $failures[$key] = $result;
                        break;
    
                    // rule failures
                    case($result instanceof RuleFailuresInterface):
                        $failures = $result;
                        break;
    
                    // invalid
                    default:
                        throw new ValidatorException(sprintf(
                            'Return value of %1$s must implement %2$s or %3$s, %4$s returned',
                            get_class($rule),
                            RuleFailureInterface::class,
                            RuleFailuresInterface::class,
                            gettype($result)
                        ));
                }
            }
        
            $rule = $rule->next();
        }
    
        if ($name && count($failures) > 1) { // more than one rule validated
            $failures = new RuleFailures([$name => $failures]);
        }
    
        return $failures;
    }
}
