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
     * @param FailuresInterface $source
     *
     * @return FailuresInterface
     */
    public function apply(FailuresInterface $source): FailuresInterface;
}
