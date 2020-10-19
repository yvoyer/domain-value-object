<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class IntegerValueTest extends TestCase
{
    public function test_should_throw_exception_when_invalid_int(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('int value "invalid" is not an integer value.');
        IntegerValueStub::fromString('invalid');
    }

    public function test_should_return_int_value(): void
    {
        self::assertSame(9, IntegerValueStub::fromString('9')->toInt());
        self::assertSame(2, IntegerValueStub::fromInt(2)->toInt());
        self::assertSame(5, IntegerValueStub::fromMixed(5)->toInt());
        self::assertSame(5, IntegerValueStub::fromMixed('5')->toInt());
    }

    public function test_should_throw_exception_when_too_high(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('int value "10" must be between "2" and "9".');
        IntegerValueStub::fromString('10');
    }

    public function test_should_throw_exception_when_too_low(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('int value "1" must be between "2" and "9".');
        IntegerValueStub::fromInt(1);
    }

    public function test_should_return_string_value(): void
    {
        self::assertSame(5, IntegerValueStub::fromString('5')->toInt());
        self::assertSame(5, IntegerValueStub::fromInt(5)->toInt());
        self::assertSame(5, IntegerValueStub::fromMixed(5)->toInt());
        self::assertSame(5, IntegerValueStub::fromMixed('5')->toInt());
    }

    public function test_it_should_return_a_random_value(): void
    {
        self::assertGreaterThanOrEqual(2, IntegerValueStub::randomValue()->toInt());
        self::assertLessThanOrEqual(9, IntegerValueStub::randomValue()->toInt());
    }
}

final class IntegerValueStub extends IntegerValue
{
    protected static function fieldName(): string
    {
        return 'int value';
    }

    protected static function minimumValue(): int
    {
        return 2;
    }

    protected static function maximumValue(): int
    {
        return 9;
    }
}
