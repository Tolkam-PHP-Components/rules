<?php

namespace Tolkam\Rules\Rule;

use Tolkam\Rules\OptionsAwareRule;

class Type extends OptionsAwareRule
{
    /**
     * @inheritDoc
     */
    public function getDefaultOption(): string
    {
        return 'type';
    }

    /**
     * @inheritDoc
     */
    public function getKnownOptions(): array
    {
        return ['type'];
    }

    /**
     * @inheritDoc
     */
    public function getRequiredOptions(): array
    {
        return ['type'];
    }

    /**
     * @inheritDoc
     */
    public function apply($value)
    {
        $type = $this->options['type'];
        
        $type = 'boolean' == $type ? 'bool' : $type;
        $isFunction = 'is_' . mb_strtolower($type);
        $cTypeFunction = 'ctype_' . mb_strtolower($type);

        if (function_exists($isFunction) && $isFunction($value)) {
            return null;
        } elseif (function_exists($cTypeFunction) && $cTypeFunction($value)) {
            return null;
        } elseif ($value instanceof $type) {
            return null;
        }

        return $this->failure('value.type.invalid', sprintf(
            'Value should be of type %s, %s given',
            $type,
            gettype($value)
        ));
    }
}
