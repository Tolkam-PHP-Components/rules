<?php declare(strict_types=1);

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\Rule;
use Tolkam\Rules\RuleInterface;

class AnyOf extends Rule
{
    /**
     * @var RuleInterface[]
     */
    protected $rules;
    
    /**
     * @param RuleInterface ...$rules
     */
    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }
    
    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        $firstFailure = null;
        
        for ($i = count($this->rules) - 1; $i >= 0; $i--) {
            if (!$firstFailure = $this->rules[$i]->apply($value)) {
                return null;
            }
        }
        
        return $firstFailure;
    }
}
