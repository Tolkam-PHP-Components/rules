<?php

namespace Tolkam\Rules;

use RuntimeException;

abstract class OptionsAwareRule extends Rule
{
    protected $options = [];

    /**
     * @param mixed $options
     */
    final public function __construct($options = null)
    {
        $isArray = is_array($options);
        $defaultOption = $this->getDefaultOption();
        $knownOptions = $this->getKnownOptions();
        $requiredOptions = $this->getRequiredOptions();

        $unknownOptions = [];
        $missingOptions = array_flip($requiredOptions);

        // array
        if ($isArray) {
            if (is_string(key($options))) {
                foreach ($options as $key => $value) {
                    if (!in_array($key, $knownOptions)) {
                        $unknownOptions[] = $key;
                    }
                    if (in_array($key, $requiredOptions)) {
                        unset($missingOptions[$key]);
                    }
                }
            }

        // value
        } elseif ($options !== null) {
            if (empty($defaultOption)) {
                throw new RuntimeException(sprintf(
                    'No default option specified for %s',
                    static::class
                ));
            }

            if (in_array($defaultOption, $requiredOptions)) {
                unset($missingOptions[$defaultOption]);
            }
            if (!in_array($defaultOption, $knownOptions)) {
                $unknownOptions[] = $defaultOption;
            }
        }

        if (!empty($unknownOptions)) {
            throw new RuntimeException(sprintf(
                'Option(s) "%2$s" of %1$s is not in known list ("%3$s")',
                static::class,
                implode('", "', $unknownOptions),
                implode('", "', $knownOptions)
            ));
        }

        if (!empty($missingOptions)) {
            throw new RuntimeException(sprintf(
                'Required option(s) "%2$s" of %1$s are missing',
                static::class,
                implode('", "', array_keys($missingOptions))
            ));
        }

        if ($isArray) {
            $this->options = $options;
        } elseif (!empty($defaultOption)) {
            $this->options[$defaultOption] = $options;
        }
    }

    /**
     * Gets default option name
     *
     * @return string
     */
    public function getDefaultOption(): ?string
    {
        return null;
    }

    /**
     * Gets known options names
     *
     * @return array
     */
    public function getKnownOptions(): array
    {
        return [];
    }

    /**
     * Gets required options names
     *
     * @return array
     */
    public function getRequiredOptions(): array
    {
        return [];
    }
}
