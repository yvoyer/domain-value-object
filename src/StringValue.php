<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use Assert\Assertion;

abstract class StringValue
{
    /**
     * @var string
     */
    private $value;

    final private function __construct(string $value)
    {
        Assertion::betweenLength(
            $value,
            static::minimumLength(),
            static::maximumLength(),
            \sprintf(
                '%s must have a length with at least %s characters and at most %s characters, "%s" given.',
                static::fieldName(),
                static::minimumLength(),
                static::maximumLength(),
                $value
            )
        );
        $this->value = $value;
    }

    final public function toString(): string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return \strlen(\trim($this->value)) === 0;
    }

    /**
     * @param string $value
     * @return static
     */
    final public static function fromString(string $value): self
    {
        return new static($value);
    }

    /**
     * @return static
     */
    abstract public static function randomValue(): self;

    /**
     * @param int $maxLength
     * @param string $prefix
     * @return static
     */
    final protected static function generateString(int $maxLength, string $prefix): self
    {
        return self::fromString(
            \substr(\uniqid($prefix), 0, $maxLength)
        );
    }

    abstract protected static function fieldName(): string;

    abstract protected static function minimumLength(): int;

    abstract protected static function maximumLength(): int;
}
