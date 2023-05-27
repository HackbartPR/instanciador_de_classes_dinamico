<?php

namespace HackbartPR\Databases\Migration;

use \PDO;

class SqliteMigration
{
    public function __construct(
        private PDO $connection
    ){}

    public function up()
    {
        try{            
            $this->createTableBanco();
            $this->createTableConvenio();            
            $this->createTableContrato();
            
            $this->fillTableBanco();
            $this->fillTableConvenio();
            $this->fillTableCotrato();

        }catch(\Exception $e) {
            echo "Houve um erro com as migrations:" . PHP_EOL . $e->getMessage() . PHP_EOL;
        }
    }

    private function createTableBanco()
    {
        $this->connection->exec(
            "CREATE TABLE IF NOT EXISTS bancos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome VARCHAR(255) NOT NULL UNIQUE
            );"
        );
    }

    private function createTableConvenio()
    {
        $this->connection->exec(
            "CREATE TABLE IF NOT EXISTS convenios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome VARCHAR(255) NOT NULL UNIQUE,
                banco_id INTEGER NOT NULL,
                CONSTRAINT convenios__bancos FOREIGN KEY (banco_id) REFERENCES bancos (id)                
            );"
        );
    }

    private function createTableContrato()
    {        
        $this->connection->exec(
            "CREATE TABLE IF NOT EXISTS contratos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome VARCHAR(50) NOT NULL,                
                convenio_id INTEGER NOT NULL,
                CONSTRAINT contratos_convenios FOREIGN KEY (convenio_id) REFERENCES convenios (id)               
            );"
        );
    }

    private function fillTableBanco()
    {        
        $this->connection->exec("INSERT INTO bancos (nome) VALUES ('SantanderFake');
            INSERT INTO bancos (nome) VALUES ('BancoDoBrasilFake');"            
        );
    }

    private function fillTableConvenio()
    {
        $this->connection->exec("INSERT INTO convenios (nome, banco_id) VALUES ('PrimeCredit', 1);
            INSERT INTO convenios (nome, banco_id) VALUES ('SecureTrust', 2);"            
        );
    }

    private function fillTableCotrato()
    {
        $this->connection->exec("INSERT INTO contratos (nome, convenio_id) VALUES ('PrimeCredit - SantanderFake', 1);
            INSERT INTO contratos (nome, convenio_id) VALUES ('SecureTrust - BancoDoBrasilFake', 2);"            
        );
    }
}