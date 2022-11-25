<?php


class RedisCache
{
    public const SESSION_DB = 1;
    public const CACHE_DB = 0;

    private static Redis $instance;
    private static Redis $instanceReplica;

    public static function getMe(bool $replica = false): Redis
    {
        if (!isset(self::$instance)) {
            self::$instance = new Redis();
            self::$instance->connect(REDIS_HOST);
            self::$instance->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
            self::$instance->setOption(Redis::OPT_PREFIX, REDIS_PREFIX);
        }

        if (REDIS_HOST !== REDIS_HOST_REPLICA && !isset(self::$instanceReplica)) {
            self::$instanceReplica = new Redis();
            self::$instanceReplica->connect(REDIS_HOST_REPLICA);
            self::$instanceReplica->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
            self::$instanceReplica->setOption(Redis::OPT_PREFIX, REDIS_PREFIX);
        }

        return ($replica && isset(self::$instanceReplica)) ? self::$instanceReplica : self::$instance;
    }

    public static function get(string $key, int $dbIndex = self::CACHE_DB): mixed
    {
        self::getMe(true)->select($dbIndex);
        return self::getMe()->get($key);
    }

    public static function set(string $key, string $value, int $ttl = 3600, int $dbIndex = self::CACHE_DB): bool
    {
        self::getMe()->select($dbIndex);
        return self::getMe()->set($key, $value, $ttl);
    }

    public static function delete(string $key, int $dbIndex = self::CACHE_DB): int
    {
        self::getMe()->select($dbIndex);
        return self::getMe()->del($key);
    }

    public static function close(): bool
    {
        return self::getMe()->close();
    }
}
