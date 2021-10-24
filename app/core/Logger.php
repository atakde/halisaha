<?php

/**
 * Logger
 */
class Logger
{

    public static $logFileName = 'app-logs.txt';

    private static function add($message, $type = 'debug'): void
    {

        $logEntry = [
            'message' => $message,
            'type' => $type,
            'timestamp' => time()
        ];

        file_put_contents(Config::get('LOG_PATH') . self::$logFileName, self::formatLogEntry($logEntry), FILE_APPEND | LOCK_EX);
    }

    private static function formatLogEntry(array $logEntry): string
    {

        $logString = "";

        if (!empty($logEntry)) {

            $logString .= '[' . date('c', $logEntry['timestamp']) . ' - ' . $logEntry['type'] . '] : ';
            $logString .= json_encode($logEntry) . "\n";
        }

        return $logString;
    }

    public static function info($message): void
    {
        self::add($message, 'INFO');
    }

    public static function warning($message): void
    {
        self::add($message, 'WARNING');
    }

    public static function error($message): void
    {
        self::add($message, 'ERROR');
    }

    public static function debug($message): void
    {
        self::add($message, 'DEBUG');
    }
}
