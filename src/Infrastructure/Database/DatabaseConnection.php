<?php 

namespace App\Infrastructure\Database;

class DatabaseConnection {
    private static \PDO $db;

    // Patrón Singleton para asegurar que solo se haga una conexión a la base de datos
    public static function getConnection() {
        if (!empty(self::$db)) {
            return self::$db;
        }

        $db_info = [
            'dsn' => "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
            'dbuser' => $_ENV['DB_USER'],
            'dbpassword' => $_ENV['DB_PASSWORD']    
        ];

        try {
            self::$db = new \PDO(
                $db_info['dsn'],
                $db_info['dbuser'],
                $db_info['dbpassword'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]
            );
            return self::$db;
        } catch (\PDOException $e) {
            die("Error connecting to the database: " . $e->getMessage());
        }
    }
}
