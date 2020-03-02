<?php

namespace Tolkam\Rules;

interface FailureInterface
{
    /**
     * Sets failure code
     *
     * @param string $code
     *
     * @return FailureInterface
     */
    public function withCode(string $code);
    
    /**
     * Sets failure text
     *
     * @param string $text
     *
     * @return FailureInterface
     */
    public function withText(string $text);
    
    /**
     * Gets code
     *
     * @return string
     */
    public function getCode(): string;
    
    /**
     * Gets message
     *
     * @return string
     */
    public function getText(): string;
    
    /**
     * Gets array representation
     *
     * @return array
     */
    public function toArray(): array;
    
    /**
     * Gets string representation
     *
     * @return string
     */
    public function __toString(): string;
}
