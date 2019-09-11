<?php

namespace Tolkam\Rules;

interface RuleInterface
{
    /**
     * Applies rule to the value
     *
     * @param  mixed  $value
     * @return RuleFailureInterface|RuleFailureInterface[]|null
     */
    public function apply($value);

    /**
     * Gets next rule to process
     *
     * @return self
     */
    public function next(): ?self;
}
