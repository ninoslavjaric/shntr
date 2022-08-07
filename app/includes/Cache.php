<?php

interface Cachable {
    public static function get(string $key): mixed;
    public static function set(string $key, mixed $value): void;
    public static function delete(string $key): void;
}

class Cache implements Cachable
{
    private const TABLE_NAME = 'cache';

    private static function getDb(): \mysqli
    {
        global $db;

        return $db;
    }

    public static function get(string $key): ?array
    {
        $query = sprintf(
            'select value from %s where `key` = %s',
            secure(static::TABLE_NAME, null, false),
            secure($key)
        );

        if ($result = self::getDb()->query($query)->fetch_assoc()) {
            $result = unserialize(htmlspecialchars_decode($result['value']));
        }

        return $result;
    }

    public static function set(string $key, mixed $value): void
    {
        static::delete($key);
        $query = sprintf(
            'insert into %s values (%s, %s)',
            secure(static::TABLE_NAME, null, false),
            secure($key),
            secure(serialize($value))
        );

        self::getDb()->query($query);
    }

    public static function delete(string $key): void
    {
        $query = sprintf(
            'delete from %s where `key` = %s',
            secure(static::TABLE_NAME, null, false),
            secure($key)
        );

        self::getDb()->query($query);
    }
}
