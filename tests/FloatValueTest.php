<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FloatValueTest extends TestCase
{
    public function test_should_throw_exception_when_invalid_value(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field name "invalid" is not numeric.');
        FloatValueStub::fromString('invalid');
    }

    public function test_should_return_string_value(): void
    {
        self::assertSame(9.8, FloatValueStub::fromFloat(9.8)->toFloat());
        self::assertSame(0.2, FloatValueStub::fromString('0.2')->toFloat());
    }

    public function test_it_should_throw_exception_when_value_too_low(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field name "0.1" must be between "0.2" and "9.8".');
        FloatValueStub::fromFloat(0.1);
    }

    public function test_it_should_throw_exception_when_value_too_high(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field name "9.9" must be between "0.2" and "9.8".');
        FloatValueStub::fromFloat(9.9);
    }

    public function test_it_should_return_a_random_value(): void
    {
        self::assertGreaterThanOrEqual(1, FloatValueStub::randomValue()->toFloat());
        self::assertLessThanOrEqual(9, FloatValueStub::randomValue()->toFloat());
    }
}

final class FloatValueStub extends FloatValue
{
    protected static function fieldName(): string
    {
        return 'Field name';
    }

    protected static function minimumValue(): float
    {
        return 0.2;
    }

    protected static function maximumValue(): float
    {
        return 9.8;
    }
}
