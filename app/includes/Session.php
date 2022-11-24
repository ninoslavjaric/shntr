<?php

require_once __DIR__ . '/RedisCache.php';

class Session implements SessionHandlerInterface
{
    public function open($savePath, $sessionName)
    {
        try {
            RedisCache::getMe();
            return true;
        } catch (Exception) {
            return false;
        }
    }

    public function close()
    {
        return RedisCache::close();
    }

    public function read($id)
    {
        if ($row = RedisCache::get($id, RedisCache::SESSION_DB)) {
            return $row;
        } else {
            return '';
        }
    }

    public function write($id, $data)
    {
        return RedisCache::set($id, $data, 3600, RedisCache::SESSION_DB);
    }

    public function destroy($id)
    {
        return RedisCache::delete($id, RedisCache::SESSION_DB) > 0;
    }

    public function gc($maxlifetime)
    {
        return true;
    }
}
