<?php declare(strict_types=1);

namespace Tolkam\Rules\FlattenStrategy;

use Tolkam\Rules\FlattenStrategyInterface;
use Tolkam\Rules\RuleFailures;
use Tolkam\Rules\RuleFailuresInterface;

class DefaultFlattenStrategy implements FlattenStrategyInterface
{
    /**
     * @inheritDoc
     */
    public function apply(RuleFailuresInterface $source): RuleFailuresInterface
    {
        return $this->doFlatten($source, new RuleFailures());
    }
    
    /**
     * Flattens source to one-dimension
     *
     * @param iterable              $source
     * @param RuleFailuresInterface $target
     * @param string|null           $startPath
     *
     * @return RuleFailuresInterface
     */
    protected function doFlatten(
        iterable $source,
        RuleFailuresInterface $target,
        string $startPath = ''
    ): RuleFailuresInterface {
        foreach ($source as $k => $v) {
            $path = $startPath !== '' ? $startPath . self::DELIMITER . $k : $k;
            
            if ($v instanceof RuleFailuresInterface) {
                $target = $this->doFlatten($v, $target, $path);
            } else {
                $target[$path] = $v;
            }
        }
        
        return $target;
    }
}