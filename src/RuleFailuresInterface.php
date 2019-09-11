<?php

namespace Tolkam\Rules;

interface RuleFailuresInterface extends \ArrayAccess, \Countable, \Iterator
{
    /**
     * Flattens self to one-dimension
     *
     * @return self
     */
    public function flatten(): self;
}
