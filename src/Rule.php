<?php

namespace Tolkam\Rules;

abstract class Rule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function next(): ?RuleInterface
    {
        return null;
    }

    /**
     * Generates failure
     *
     * @param  string $key
     * @param  string $message
     * @return RuleFailureInterface
     */
    public function failure(string $key, string $message)
    {
        return new RuleFailure($key, $message);
    }
}
