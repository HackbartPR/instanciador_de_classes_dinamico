<?php

namespace HackbartPR\Models;

use HackbartPR\Models\Banco;
use HackbartPR\Models\Model;

class Convenio implements Model
{
    public function __construct(
        private ?int $id = null, 
        public string $nome,        
        public Banco $banco
    ){}
    
    public function codigo(): ?int
    {
        return $this->id;
    }
}