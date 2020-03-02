<?php

namespace Tolkam\Rules;

abstract class Rule implements RuleInterface
{
    /**
     * Generates failure
     *
     * @param string $code
     * @param string $message
     *
     * @return RuleFailureInterface
     */
    public function failure(string $code, string $message)
    {
        return new RuleFailure($code, $message);
    }
}
