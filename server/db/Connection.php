<?php
require_once(__DIR__ . '/Config.php');

define('BASE_DSN', 'mysql:host' . HOST);
define('DSN', BASE_DSN . ';dbname=' . DB);
define('NO_DATABASE_ERROR', 1049);

class DatabaseConnection
{
    private static $pdo = null;

    public static function connect()
    {
        try {
            if (self::$pdo === null) {
                self::$pdo = new PDO(dsn: DSN, username: USER, options: CONFIG);
                Setup::createTable(self::$pdo);

                return self::$pdo;
            }

            return self::$pdo;
        } catch (\PDOException $error) {
            if ($error->getCode() === NO_DATABASE_ERROR) {
                Setup::createDatabase(self::$pdo);
                Setup::createTable(self::$pdo);
            };

            throw new \PDOException($error->getMessage(), $error->getCode());
        }
    }

    private static function setup()
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(dsn: DSN, username: USER, options: CONFIG);
        }

        try {
            Setup::createDatabase(self::$pdo);
            return Setup::createTable(self::$pdo);
        } catch (\PDOException $error) {
            throw new \PDOException($error->getMessage(), $error->getCode());
        }
    }
}
