<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use InvalidArgumentException;
use function array_map;
use function array_rand;
use function array_search;
use function implode;
use function sprintf;
use function strtolower;

/**
 * A list of constant string. Only one of the option can be used at a time
 */
abstract class EnumValue
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $lowerValue = strtolower($value);
        $allowed = array_map('strtolower', $this->allowedOptions());
        $foundIndex = array_search($lowerValue, $allowed, true);
        if (false === $foundIndex) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s "%s" is not one of the valid values, allowed: "%s".',
                    $this->fieldName(),
                    $value,
                    implode(', ', $allowed)
                )
            );
        }

        $this->value = $allowed[$foundIndex];
    }

    /**
     * @return string[]
     */
    abstract protected static function allowedOptions(): array;

    abstract protected function fieldName(): string;

    final protected function toFormattedString(callable $formatter): string
    {
        return $formatter($this->value);
    }

    final public function toString(): string
    {
        return $this->value;
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
    public static function randomValue(): self
    {
        $values = static::allowedOptions();
        return self::fromString($values[array_rand($values)]);
    }
}
