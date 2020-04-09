<?php

namespace Tolkam\Rules;

abstract class Rule implements RuleInterface
{
    /**
     * Generates failure
     *
     * @param string $code
     * @param string $message
     * @param array  $params
     *
     * @return FailureInterface
     */
    public function failure(string $code, string $message, array $params = [])
    {
        return new Failure($code, $message, $params);
    }
}
