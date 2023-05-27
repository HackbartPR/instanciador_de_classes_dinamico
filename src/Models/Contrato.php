<?php

namespace HackbartPR\Models;

use HackbartPR\Models\Model;

class Contrato implements Model
{
    public function __construct(
        private ?int $id = null, 
        public string $nome,
        public Convenio $convenio, 
    ){}
    
    public function codigo(): ?int
    {
        return $this->id;
    }
}