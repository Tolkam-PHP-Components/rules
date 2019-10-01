<?php

namespace Tolkam\Rules;

abstract class Rule implements RuleInterface
{
    /**
     * Generates failure
     *
     * @param string $id
     * @param string $message
     *
     * @return RuleFailureInterface
     */
    public function failure(string $id, string $message)
    {
        return new RuleFailure($id, $message);
    }
}
