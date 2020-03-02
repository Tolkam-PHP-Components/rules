<?php declare(strict_types=1);

namespace Tolkam\Rules\FlattenStrategy;

use Tolkam\Rules\FailureInterface;
use Tolkam\Rules\FailuresInterface;

class NamespacedCodesStrategy extends DefaultFlattenStrategy
{
    /**
     * @inheritDoc
     */
    protected function doFlatten(
        iterable $source,
        FailuresInterface $target,
        string $startPath = ''
    ): FailuresInterface {
        $delimiter = self::DELIMITER;
        
        foreach ($source as $k => $v) {
            $path = $startPath !== '' ? $startPath . $delimiter . $k : $k;
            
            if ($v instanceof FailuresInterface) {
                $target = $this->doFlatten($v, $target, $path);
            } else {
                /** @var FailureInterface $v */
                $target[$path] = $v->withCode($path . $delimiter . $v->getCode());
            }
        }
        
        return $target;
    }
}
