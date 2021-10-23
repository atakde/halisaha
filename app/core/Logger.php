<?php

/**
 * Logger
 */
class Logger
{
    private static function add($message, $type = 'debug'): void
    {

        $logEntry = [
            'message' => $message,
            'type' => $type,
            'timestamp' => time()
        ];

        file_put_contents(Config::get('LOG_PATH') . 'app-logs.txt', self::formatLogEntry($logEntry), FILE_APPEND | LOCK_EX);
    }

    private static function formatLogEntry(array $logEntry): string
    {

        $logString = "";

        if (!empty($logEntry)) {

            $logString .= '[' . date('c', $logEntry['timestamp']) . '] : ';
            unset($logEntry['timestamp']);
            $logString .= json_encode($logEntry) . "\n";
        }

        return $logString;
    }

    public static function info($message): void
    {
        self::add($message, 'info');
    }

    public static function warning($message): void
    {
        self::add($message, 'warning');
    }

    public static function error($message): void
    {
        self::add($message, 'error');
    }

    public static function debug($message): void
    {
        self::add($message, 'debug');
    }
}
