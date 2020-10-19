<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

abstract class BooleanValue
{
    /**
     * @var bool
     */
    private $value;

    private function __construct(bool $value)
    {
        $this->value = $value;
    }

    final public function toBool(): bool
    {
        return $this->value;
    }

    /**
     * @param bool $value
     * @return static
     */
    final public static function fromBoolean(bool $value): self
    {
        return new static($value);
    }

    /**
     * @return static
     */
    final public static function asTrue(): self
    {
        return static::fromBoolean(true);
    }

    /**
     * @return static
     */
    final public static function asFalse(): self
    {
        return static::fromBoolean(false);
    }
}
