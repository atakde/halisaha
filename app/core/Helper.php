<?php

class Helper
{
    public static function filterXSS($value, $stripTags = false)
    {
        if (is_string($value)) {
            if ($stripTags) {
                $value = strip_tags($value);
            }
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        } elseif (is_array($value) || is_object($value)) {
            foreach ($value as &$each) {
                $each = self::filterXSS($each);
            }
        }

        return $value;
    }
}
