<?php

namespace Tolkam\Rules;

abstract class Rule implements RuleInterface
{
    /**
     * @var RuleInterface|null
     */
    private $nextRule = null;
    
    /**
     * @inheritDoc
     */
    public function next(): ?RuleInterface
    {
        return $this->nextRule;
    }
    
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
    
    /**
     * Sets the next rule to apply
     *
     * @param RuleInterface|null $nextRule
     *
     * @return Rule
     */
    protected function setNextRule(?RuleInterface $nextRule): Rule
    {
        $this->nextRule = $nextRule;
    
        return $this;
    }
}
