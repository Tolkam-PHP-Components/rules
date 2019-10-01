<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;

class Type extends Rule
{
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        $type = $this->type;
        
        $type = $type === 'boolean' ? 'bool' : $type;
        
        $isFunction = 'is_' . mb_strtolower($type);
        $cTypeFunction = 'ctype_' . mb_strtolower($type);
        
        if (function_exists($isFunction) && $isFunction($value)) {
            return null;
        } elseif (function_exists($cTypeFunction) && $cTypeFunction($value)) {
            return null;
        } elseif ($value instanceof $type) {
            return null;
        }
        
        return $this->failure('type.invalid', sprintf(
            'Value should be of type %s, %s given',
            $type,
            gettype($value)
        ));
    }
}
