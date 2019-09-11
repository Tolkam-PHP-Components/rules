<?php

namespace Tolkam\Rules;

interface ValidatorInterface
{
    /**
     * Validates value against rule
     *
     * @param  RuleInterface $rule
     * @param  mixed         $value
     * @param  string|null   $name
     * @return RuleFailuresInterface
     */
    public static function validate(RuleInterface $rule, $value, string $name = null): RuleFailuresInterface;
}
