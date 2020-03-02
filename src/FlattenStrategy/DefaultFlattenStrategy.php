<?php declare(strict_types=1);

namespace Tolkam\Rules\FlattenStrategy;

use Tolkam\Rules\Failures;
use Tolkam\Rules\FailuresInterface;
use Tolkam\Rules\FlattenStrategyInterface;

class DefaultFlattenStrategy implements FlattenStrategyInterface
{
    /**
     * @inheritDoc
     */
    public function apply(FailuresInterface $source): FailuresInterface
    {
        return $this->doFlatten($source, new Failures());
    }
    
    /**
     * Flattens source to one-dimension
     *
     * @param iterable          $source
     * @param FailuresInterface $target
     * @param string|null       $startPath
     *
     * @return FailuresInterface
     */
    protected function doFlatten(
        iterable $source,
        FailuresInterface $target,
        string $startPath = ''
    ): FailuresInterface {
        foreach ($source as $k => $v) {
            $path = $startPath !== '' ? $startPath . self::DELIMITER . $k : $k;
            
            if ($v instanceof FailuresInterface) {
                $target = $this->doFlatten($v, $target, $path);
            } else {
                $target[$path] = $v;
            }
        }
        
        return $target;
    }
}
