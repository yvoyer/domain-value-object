<?php declare(strict_types=1);

namespace Star\Component\ValueObject;

use PHPUnit\Framework\TestCase;

final class BooleanValueTest extends TestCase
{
    public function test_should_return_boolean_true(): void
    {
        self::assertTrue(BooleanValueStub::asTrue()->toBool());
    }

    public function test_should_return_boolean_false(): void
    {
        self::assertFalse(BooleanValueStub::asFalse()->toBool());
    }
}

final class BooleanValueStub extends BooleanValue
{
}
