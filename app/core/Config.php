<?php

/**
 * Config
 */
class Config
{
    private static $config;

    public static function get($key)
    {
        if (!isset(self::$config) && file_exists('../app/config/config.php')) {
            self::$config = require_once('../app/config/config.php');
        }

        return self::$config[$key] ?? null;
    }
}
