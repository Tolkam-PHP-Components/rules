<?php declare(strict_types=1);

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;

class Pattern extends Rule
{
    /**
     * @var string
     */
    private string $pattern;
    
    /**
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        $options = ['regexp' => $this->pattern];
        
        if (filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => $options]) === false) {
            return $this->failure(
                'value.invalid',
                sprintf('Value does not match defined pattern "%s"', $this->pattern)
            );
        }
        
        return null;
    }
}
