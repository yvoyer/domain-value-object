<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use Assert\Assertion;
use function mt_rand;
use function round;

abstract class FloatValue
{
    /**
     * @var float
     */
    private $value;

    private function __construct(float $value)
    {
        Assertion::between(
            $value,
            static::minimumValue(),
            static::maximumValue(),
            static::fieldName() . ' "%s" must be between "%s" and "%s".'
        );
        $this->value = $value;
    }

    public function toFloat(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return static
     */
    final public static function fromFloat(float $value): self
    {
        return new static($value);
    }

    /**
     * @param string $value
     * @return static
     */
    final public static function fromString(string $value): self
    {
        Assertion::numeric(
            $value,
            static::fieldName() . ' "%s" is not numeric.'
        );

        return static::fromFloat((float) $value);
    }

    /**
     * @return static
     */
    final public static function randomValue(): self
    {
        return self::fromFloat(
            mt_rand(
                (int) round((static::minimumValue() + 1), 0, PHP_ROUND_HALF_DOWN),
                (int) round((static::maximumValue() - 1), 0, PHP_ROUND_HALF_DOWN)
            )
        );
    }

    abstract protected static function fieldName(): string;

    abstract protected static function minimumValue(): float;

    abstract protected static function maximumValue(): float;
}
