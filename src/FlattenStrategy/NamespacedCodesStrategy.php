<?php declare(strict_types=1);

namespace Tolkam\Rules\FlattenStrategy;

use Tolkam\Rules\RuleFailuresInterface;

class NamespacedCodesStrategy extends DefaultFlattenStrategy
{
    /**
     * @inheritDoc
     */
    protected function doFlatten(
        iterable $source,
        RuleFailuresInterface $target,
        string $startPath = ''
    ): RuleFailuresInterface {
        $delimiter = self::DELIMITER;
        
        foreach ($source as $k => $v) {
            $path = $startPath !== '' ? $startPath . $delimiter . $k : $k;
            
            if ($v instanceof RuleFailuresInterface) {
                $target = $this->doFlatten($v, $target, $path);
            } else {
                $target[$path] = $v->setCode($path . $delimiter . $v->getCode());
            }
        }
        
        return $target;
    }
}