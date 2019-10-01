<?php

namespace Tolkam\Rules;

interface RuleFailuresInterface extends \ArrayAccess, \Countable, \Iterator
{
    /**
     * Flattens self to one-dimension
     *
     * @param FlattenStrategyInterface|null $strategy
     *
     * @return self
     */
    public function flatten(FlattenStrategyInterface $strategy = null): self;
    
    /**
     * Gets array representation
     *
     * @return array
     */
    public function toArray(): array;
}
