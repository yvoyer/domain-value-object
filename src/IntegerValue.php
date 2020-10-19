<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use Assert\Assertion;
use function mt_rand;

abstract class IntegerValue
{
    /**
     * @var int
     */
    private $value;

    private function __construct(int $value)
    {
        Assertion::between(
            $value,
            static::minimumValue(),
            static::maximumValue(),
            static::fieldName() . ' "%s" must be between "%s" and "%s".'
        );
        $this->value = $value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return static
     */
    final public static function fromInt(int $value): self
    {
        return new static($value);
    }

    /**
     * @param string $value
     * @return static
     */
    final public static function fromString(string $value): self
    {
        Assertion::integerish(
            $value,
            static::fieldName() . ' "%s" is not an integer value.'
        );
        return static::fromInt((int) $value);
    }

    /**
     * @param string|int $value
     * @return static
     */
    final public static function fromMixed($value): self
    {
        return static::fromInt((int) $value);
    }

    /**
     * @return static
     */
    final public static function randomValue(): self
    {
        return self::fromInt(mt_rand(static::minimumValue(), static::maximumValue()));
    }

    abstract protected static function fieldName(): string;

    abstract protected static function minimumValue(): int;

    abstract protected static function maximumValue(): int;
}
