<?php declare(strict_types=1);

namespace Tolkam\Rules;

interface FlattenStrategyInterface
{
    /**
     * Delimiter character
     */
    const DELIMITER = '.';
    
    /**
     * Applies the strategy
     *
     * @param RuleFailuresInterface $source
     *
     * @return RuleFailuresInterface
     */
    public function apply(RuleFailuresInterface $source): RuleFailuresInterface;
}