<?php

namespace Tolkam\Rules;

use RuntimeException;
use Tolkam\Rules\FlattenStrategy\DefaultFlattenStrategy;

class RuleFailures implements RuleFailuresInterface
{
    /**
     * items
     *
     * @var array
     */
    protected $items = [];
    
    /**
     * @param iterable $items
     */
    public function __construct(iterable $items = [])
    {
        foreach ($items as $k => $v) {
            $this->add($k, $v);
        }
    }
    
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $arr = [];
        
        foreach ($this->items as $k => $v) {
            if ($v instanceof RuleFailuresInterface || $v instanceof RuleFailureInterface) {
                $arr[$k] = $v->toArray();
            } else {
                $arr[$k] = $v;
            }
        }
        
        return $arr;
    }
    
    /**
     * @inheritDoc
     */
    public function flatten(FlattenStrategyInterface $strategy = null): RuleFailuresInterface
    {
        if (!$strategy) {
            $strategy = new DefaultFlattenStrategy();
        }
        
        return $strategy->apply($this);
    }
    
    /**
     * Adds item
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function add($offset, $value)
    {
        if (!($value instanceof RuleFailureInterface) && !($value instanceof RuleFailuresInterface)) {
            throw new RuntimeException(sprintf(
                'Value at offset "%1$s" must implement %2$s or %3$s, %4$s given',
                $offset,
                RuleFailureInterface::class,
                RuleFailuresInterface::class,
                gettype($value)
            ));
        }
        
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }
    
    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->items);
    }
    
    /**
     * @inheritDoc
     */
    public function rewind()
    {
        return reset($this->items);
    }
    
    /**
     * @inheritDoc
     */
    public function current()
    {
        return current($this->items);
    }
    
    /**
     * @inheritDoc
     */
    public function key()
    {
        return key($this->items);
    }
    
    /**
     * @inheritDoc
     */
    public function next()
    {
        return next($this->items);
    }
    
    /**
     * @inheritDoc
     */
    public function valid()
    {
        return key($this->items) !== null;
    }
    
    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->add($offset, $value);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }
}
