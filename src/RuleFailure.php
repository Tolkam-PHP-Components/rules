<?php

namespace Tolkam\Rules;

use RuntimeException;

class RuleFailure implements RuleFailureInterface
{
    /**
     * Failure id
     *
     * @var string
     */
    protected $id;
    
    /**
     * Failure text
     *
     * @var string
     */
    protected $text;
    
    /**
     * @param string      $id
     * @param string|null $text
     */
    public function __construct(string $id, string $text = null)
    {
        $allowed = 'a-zA-Z0-9:\.';
        if (preg_match('~[^' . $allowed . ']~', $id)) {
            throw new RuntimeException(
                sprintf('Invalid failure id: allowed characters are "%s"', $allowed)
            );
        }
        
        $this->id = $id;
        $this->text = $text;
    }
    
    /**
     * @param string $prop
     *
     * @return mixed
     */
    public function __get(string $prop)
    {
        $getter = 'get' . ucfirst($prop);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        
        return null;
    }
    
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'text' => $this->getText(),
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->text;
    }
    
    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    /**
     * @inheritDoc
     */
    public function getText(): string
    {
        return $this->text;
    }
    
    /**
     * @inheritDoc
     */
    public function setId(string $id)
    {
        return new static($id, $this->getText());
    }
    
    /**
     * @inheritDoc
     */
    public function setText(string $text)
    {
        return new static($this->getId(), $text);
    }
}
