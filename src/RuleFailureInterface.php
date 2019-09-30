<?php

namespace Tolkam\Rules;

interface RuleFailureInterface
{
    /**
     * Sets key
     *
     * @param string $key
     *
     * @return RuleFailureInterface
     */
    public function setKey(string $key);
    
    /**
     * Sets message
     *
     * @param string $message
     *
     * @return RuleFailureInterface
     */
    public function setMessage(string $message);
    
    /**
     * Gets key
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Gets message
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Gets string representation
     *
     * @return string
     */
    public function __toString(): string;
}
