<?php declare(strict_types=1);

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;

class Callback extends Rule
{
    /**
     * @var callable
     */
    protected $callback;
    
    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        return call_user_func($this->callback, $value);
    }
}