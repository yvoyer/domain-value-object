# Star Value Object

[![Build Status](https://travis-ci.org/yvoyer/domain-value-object.svg?branch=main)](https://travis-ci.org/yvoyer/domain-value-object)

This repository contains base classes that can help to create named Value objectsBase classes for Value Object for 
you DDD projects.

## Usages

Given the class `YouClass` extends the example class:

### BooleanValue class

```php
YourClass::fromBoolean(true);
YourClass::asTrue();
YourClass::asFalse();
```

### EnumValue class

The `EnumValue` class is a hard-coded list of options. This is an object that must have only one value upon creation, 
and that is represented as a string.

```php
$object = YourClass::fromString('Option 1');
$object->toString(); // Option 1

// Return a random value from the pre-defined list
YourClass::randomValue();
$object->toString(); // One of the valid values
```

### FloatValue class

```php
YourClass::fromFloat(12.34)->toFloat(); // 12.34
YourClass::fromString('12.34')->toFloat(); // 12.34
YourClass::randomValue()->toFloat(); // A random float included inside a configured range.
```

### IntegerValue class

```php
YourClass::fromInt(12)->toFloat(); // 12
YourClass::fromString('12')->toFloat(); // 12
YourClass::randomValue()->toInt(); // A random int included inside a configured range.
```

### StringValue class

```php
YourClass::fromString('something')->toString(); // something
YourClass::fromString('')->isEmpty(); // true
YourClass::fromString('str')->isEmpty(); // false
YourClass::randomValue()->toString(); // A random string matching a configured length.
```

### Exception

When a validation exception occurs inside your value object, 
the message will contain the concept name representation in the message. 

```php
final class MyAggregateName extends StringValue
{
    protected static function fieldName(): string
    {
        return 'My aggregate name';
    }

    protected static function minimumLength(): int
    {
        return 10;
    }

    protected static function maximumLength(): int
    {
        return 100;
    }
}
// Exception message: "My aggregate name must have a length with at least 10 characters and at most 100 characters, "too low" given."
YourStringClass::fromString('too low'); // throws \InvalidArgumentException
```
