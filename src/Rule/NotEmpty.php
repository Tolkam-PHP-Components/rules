<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class NotEmpty extends Rule
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
            return $this->failure('value.notEmpty.invalid', 'Value must not be empty');
        }
        
        return null;
    }

    /**
     * @inheritDoc
     */
    public function next(): ?RuleInterface
    {
        return $this->nextRule;
    }
}
