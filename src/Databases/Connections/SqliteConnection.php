<?php

namespace HackbartPR\Databases\Connections;

use Exception;
use PDO;

final class SqliteConnection
{
    /**
     * Cria a conexão com o banco SQLite
     * 
     * @return PDO
     */
    public static function createConnection(): PDO
    {
        try{
            $dbPath = __DIR__ . '/../../../DB.sqlite';
            $connection = new PDO("sqlite:{$dbPath}");
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            return $connection;
        } catch (Exception $e) {
            echo "Houve um erro com a conexão com o banco:" . PHP_EOL . $e->getMessage() . PHP_EOL;
        }
        
    }
}