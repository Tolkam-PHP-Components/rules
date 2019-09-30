<?php

namespace Tolkam\Rules;

interface RuleFailureInterface
{
    /**
     * Sets failure id
     *
     * @param string $id
     *
     * @return RuleFailureInterface
     */
    public function setId(string $id);
    
    /**
     * Sets failure text
     *
     * @param string $text
     *
     * @return RuleFailureInterface
     */
    public function setText(string $text);
    
    /**
     * Gets id
     *
     * @return string
     */
    public function getId(): string;
    
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
