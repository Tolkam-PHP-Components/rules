<?php

namespace Tolkam\Rules;

use RuntimeException;

class RuleFailure implements RuleFailureInterface
{
    /**
     * failure key
     * @var string
     */
    protected $key;

    /**
     * failure message
     * @var string
     */
    protected $message;

    /**
     * @param string      $key
     * @param string|null $message
     */
    public function __construct(string $key, string $message = null)
    {
        $allowed = 'a-zA-Z0-9:\.';
        if (preg_match('~[^' . $allowed . ']~', $key)) {
            throw new RuntimeException(
                sprintf('Key allowed characters are "%s"', $allowed)
            );
        }

        $this->key = $key;
        $this->message = $message;
    }

    /**
     * @param  string $prop
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
    public function __toString(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
    /**
     * @inheritDoc
     */
    public function setKey(string $key)
    {
        return new static($key, $this->getMessage());
    }
    
    /**
     * @inheritDoc
     */
    public function setMessage(string $message)
    {
        return new static($this->getKey(), $message);
    }
}
