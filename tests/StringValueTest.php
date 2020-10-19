<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use function str_repeat;

final class StringValueTest extends TestCase
{
    public function test_should_throw_exception_when_too_short(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Field name with crop must have a length with at least 5 characters and at most 10 characters, "ab" given.'
        );
        WithCropStub::fromString('ab');
    }

    public function test_should_throw_exception_when_too_long(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Field name with crop must have a length with at least 5 characters'
            . ' and at most 10 characters, "fffffffffff" given.'
        );
        WithCropStub::fromString(str_repeat('f', 11));
    }

    public function test_should_return_string_representation(): void
    {
        self::assertSame('value', WithCropStub::fromString('value')->toString());
    }

    public function test_it_should_generate_a_random_value_when_crop_needed(): void
    {
        self::assertStringContainsString('prefix-', WithCropStub::randomValue()->toString());
    }

    public function test_it_should_generate_a_random_value_when_no_crop_needed(): void
    {
        self::assertStringContainsString('prefix-', WithoutCropStub::randomValue()->toString());
    }

    public function test_it_should_return_a_random_value(): void
    {
        self::assertStringContainsString('prefix-', WithoutCropStub::randomValue()->toString());
    }
}

final class WithCropStub extends StringValue
{
    protected static function fieldName(): string
    {
        return 'Field name with crop';
    }

    protected static function minimumLength(): int
    {
        return 5;
    }

    protected static function maximumLength(): int
    {
        return 10;
    }

    public static function randomValue(): StringValue
    {
        return self::generateString(10, 'prefix-');
    }
}

final class WithoutCropStub extends StringValue
{
    protected static function fieldName(): string
    {
        return 'Field name without crop';
    }

    protected static function minimumLength(): int
    {
        return 5;
    }

    protected static function maximumLength(): int
    {
        return 100;
    }

    public static function randomValue(): StringValue
    {
        return self::generateString(100, 'prefix-');
    }
}
