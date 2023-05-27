<?php

require_once(__DIR__ . '/vendor/autoload.php');

use HackbartPR\Databases\Migration\SqliteMigration;
use HackbartPR\Databases\Connections\SqliteConnection;

// Realiza a criação das tabelas no banco de dados
$connection = SqliteConnection::createConnection();
$migration = new SqliteMigration($connection);
$migration->up();