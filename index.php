<?php

require_once(__DIR__ . '/vendor/autoload.php');

use HackbartPR\Databases\Connections\SqliteConnection;
use HackbartPR\Databases\Repository\SqliteRepository;

$connection = SqliteConnection::createConnection();
$repository = new SqliteRepository($connection);

$contratos = $repository->findAllContratos();

print_r($contratos);