<?php

class Request
{
    public static function get($key, $return = false)
    {
        if (!empty($key) && isset($_GET[$key])) {
            return $_GET[$key];
        }

        return $return;
    }

    public static function post($key, $return = false)
    {
        if (!empty($key) && isset($_POST[$key])) {
            return $_POST[$key];
        }

        return $return;
    }

    public static function readCookie($key)
    {
        if (!empty($key) && isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }

        return false;
    }
}
