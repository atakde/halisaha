<?php

/**
 * Database
 */
class Database
{

    private static $factory;
    private $connection;

    public static function getFactory()
    {
        if (!self::$factory) {
            self::$factory = new self();
        }

        return self::$factory;
    }

    public function getConnection()
    {
        if (!$this->connection) {
            try {
                $this->connection = new PDO(
                    Config::get('DB_TYPE') . ':host=' . Config::get('DB_HOST') . ";port=" .  Config::get('DB_PORT')  . ';dbname=' .
                        Config::get('DB_NAME') . ';charset=' . Config::get('DB_CHARSET'),
                    Config::get('DB_USER'),
                    Config::get('DB_PASS'),
                    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
                );
                $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException  $error) {
                var_dump($error->getMessage());
                exit(0);
            }
        }

        return $this->connection;
    }
}
