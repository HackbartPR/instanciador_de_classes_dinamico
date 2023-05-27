<?php

namespace HackbartPR\Databases\Repository;

use HackbartPR\Models\Contrato;
use HackbartPR\Traits\Sanitizer;

class SqliteRepository
{
    use Sanitizer;

    public function __construct(
        private \PDO $connection,
    ){}

    public function findAllContratos(): array
    {
        try {
            $stmt = $this->connection->query("SELECT CT.id AS 'contrato_id', CT.nome AS 'contrato_nome',
            BC.id AS 'banco_id', BC.nome AS 'banco_nome', CV.id AS 'convenio_id', CV.nome AS 'convenio_nome'
            FROM contratos CT
            INNER JOIN convenios CV ON CV.id = CT.convenio_id
            INNER JOIN bancos BC ON BC.id = CV.banco_id");

            $list = $stmt->fetchAll();
            
            return $this->sanitizeList(Contrato::class, $list);
        } catch (\Exception $e) {
            echo "" . PHP_EOL;
            echo "Erro ao buscar todos os contratos: " . PHP_EOL . $e->getMessage();
        }
    }
}