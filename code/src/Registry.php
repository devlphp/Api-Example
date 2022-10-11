<?php
declare(strict_types=1);

namespace ApiExample;

class Registry
{
    static array $items = [];

    final public static function set(RegistryKeys $key, $value): void
    {
        self::$items[$key->value] = $value;
    }

    final public static function get(RegistryKeys $key): mixed
    {
        return self::$items[$key->value];
    }
}