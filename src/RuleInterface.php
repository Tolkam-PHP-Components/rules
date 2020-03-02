<?php

namespace Tolkam\Rules;

interface RuleInterface
{
    /**
     * Applies rule to the value
     *
     * @param mixed $value
     *
     * @return FailureInterface|FailureInterface[]|null
     */
    public function apply($value);
}
