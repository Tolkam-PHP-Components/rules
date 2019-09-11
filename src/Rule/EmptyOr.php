<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class EmptyOr extends Rule
{
    /**
     * next rule
     * @var RuleInterface
     */
    protected $nextRule;

    /**
     * @param RuleInterface|null $nextRule
     */
    public function __construct(RuleInterface $nextRule = null)
    {
        $this->nextRule = $nextRule;
    }

    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        if (empty($value)) {
            $this->nextRule = null;
            return;
        }
    }

    /**
     * @inheritDoc
     */
    public function next(): ?RuleInterface
    {
        return $this->nextRule;
    }
}
