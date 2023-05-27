<?php

namespace HackbartPR\Models;

use HackbartPR\Models\Model;

class Banco implements Model
{
    public function __construct(
        private ?int $id = null, 
        public string $nome
    ){}

    public function codigo(): ?int
    {
        return $this->id;
    }
}