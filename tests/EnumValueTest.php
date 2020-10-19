<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class EnumValueTest extends TestCase
{
    public function test_should_throw_exception_when_invalid_value(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field name "invalid" is not one of the valid values, allowed: "valid".');
        EnumValueStub::fromString('invalid');
    }

    public function test_should_return_string_value(): void
    {
        self::assertSame('valid', EnumValueStub::fromString('valid')->toString());
    }

    public function test_should_allow_to_be_build_with_different_cases(): void
    {
        self::assertSame('valid', EnumValueStub::fromString('VaLiD')->toString());
    }

    public function test_it_should_return_a_random_value(): void
    {
        self::assertStringContainsString('valid', EnumValueStub::randomValue()->toString());
    }
}

final class EnumValueStub extends EnumValue
{
    protected static function allowedOptions(): array
    {
        return ['valid'];
    }

    protected function fieldName(): string
    {
        return 'Field name';
    }
}
