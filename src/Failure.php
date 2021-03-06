<?php

namespace Tolkam\Rules;

use RuntimeException;

/**
 * @property string $code
 * @property string $text
 * @property array  $params
 */
class Failure implements FailureInterface
{
    /**
     * Failure code
     *
     * @var string
     */
    protected string $code;
    
    /**
     * Failure text
     *
     * @var string|null
     */
    protected ?string $text;
    
    /**
     * @var array
     */
    protected array $params;
    
    /**
     * @param string      $code
     * @param string|null $text
     * @param array       $params
     */
    public function __construct(string $code, string $text = null, array $params = [])
    {
        $allowed = 'a-zA-Z0-9:\.';
        if (preg_match('~[^' . $allowed . ']~', $code)) {
            throw new RuntimeException(
                sprintf('Invalid failure code: allowed characters are "%s"', $allowed)
            );
        }
        
        $this->code = $code;
        $this->text = $text;
        $this->params = $params;
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
            'code' => $this->getCode(),
            'text' => $this->getText(),
            'params' => $this->getParams(),
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
    public function getCode(): string
    {
        return $this->code;
    }
    
    /**
     * @inheritDoc
     */
    public function getText(): ?string
    {
        return $this->text;
    }
    
    /**
     * @inheritDoc
     */
    public function getParams(): array
    {
        return $this->params;
    }
    
    /**
     * @inheritDoc
     */
    public function withCode(string $code)
    {
        return new static($code, $this->getText());
    }
    
    /**
     * @inheritDoc
     */
    public function withText(string $text)
    {
        return new static($this->getCode(), $text);
    }
    
    /**
     * @inheritDoc
     */
    public function withParams(array $params)
    {
        return new static($this->getCode(), $this->getText(), $params);
    }
}
