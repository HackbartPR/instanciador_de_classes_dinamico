<?php

namespace HackbartPR\Traits;

use ReflectionClass;
use HackbartPR\Models\Model;

trait Sanitizer
{
    /**
     * Responsável por receber os valores consultados no banco de dados e armazenar todos os objeto que serão instanciados
     * 
     * @param string $class = Ex: HackbatPR\Models\Banco
     * @param array $list[] = Lista de valores obtidos na consulta ao banco de dados
     * @param array $models[] = Retorna uma lista de objetos instanciados
     */
    protected function sanitizeList(string $class, array $list): array
    {                
        $objectList = [];
        foreach ($list as $item) {
            $objectList[] = $this->startSanitizeList($class, $item);
        }
                
        return $objectList;
    }

    /**
     * Responsável por realizar a instância do objeto, utilizando recursão para instanciar propriedades que são objetos de 
     * outras classes
     * 
     * @param string $class = Ex: HackbatPR\Models\Banco
     * @param array $list[] = Lista de valores obtidos na consulta ao banco de dados
     * @param Model $model
     */
    private function startSanitizeList(string $class, array $list): Model
    {
        $refClass = new ReflectionClass($class);
        $attributes = $this->getPropertiesInfo($refClass);

        $tempResult = [];        
        foreach ($attributes as $attr) {
            if (class_exists($attr['type'])) {
                $tempResult[] = $this->startSanitizeList($attr['type'], $list);
            } 

            $tempResult[] = $attr['name'];
        }
        
        $tempResult = $this->matchPropertiesList($tempResult, $list);
        $tempResult = $this->cleanListName($refClass, $tempResult);
        $tempResult = $this->renamePositionalArguments($tempResult);
                       
        return $refClass->newInstanceArgs($tempResult);
    }
    
    /**
     * Responsável por verificar se existe algum indice do array indexados, ao invés de estar usando array associativo.
     * Somente objeto estão usando array indexado, portanto pega-se o nome da classe e associa o array com o nome da classe.
     * 
     * @param array $props []
     * @return array $result [] = retorna o array contendo todos seus valores associativos
     */
    private function renamePositionalArguments(array $props): array
    {
        $result = [];
        foreach ($props as $key => $value) {
            if (is_a($value, Model::class)) {
                $ref = new ReflectionClass($value);
                $className = strtolower($ref->getShortName());
                $result[$className] = $value;
                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Responsável por receber as propriedades da classe a ser instanciada e comparar com os valores obtidos do banco, 
     * criando uma nova lista com somente os valores vindos do banco pertencentes a classe a ser instanciada.
     * 
     * @param array $props[] = propriedades da classe.
     * @param array $list[] = lista obtida da consulta do banco.
     * @return array $result[] = lista com valores do banco pertencentes a classe.
     */
    private function matchPropertiesList(array $props, array $list): array
    {
        $result = [];

        foreach ($props as $prop) {
            if (is_a($prop, Model::class)) {
                $result[] = $prop;
                continue;
            }
            
            foreach ($list as $key => $value) {
                if ($prop === $key) {
                    $result[$key] = $value;
                    break;
                }                 
            }
        }

        return $result;
    }

    /**
     * Responsável por receber todos os parametros da classe $ref e retirar o prefixo nomedaclasse_.
     * A retirada do prefixo é para poder ter os nomes das propriedades como são encontradas na classe
     * e poder realizar a instância da mesma.
     * 
     * @param ReflectionClass $ref
     * @param array $list[]
     * @return array $results[] 
     */
    private function cleanListName(ReflectionClass $ref, array $list): array
    {
        $className = strtolower($ref->getShortName());
        $result = [];

        foreach ($list as $key => $value) {
            $newKey = str_replace($className . '_', '', $key);
            $result[$newKey] = $value;
        }
        
        return $result;
    }

    /**
     * Responsável por receber uma classe e retornar todos os nomes das suas propriedades renomeados 
     * com o prefixo nomedaclasse_ e seus respectivos tipos. O prefixo_ é reponsável por realizar o match 
     * com os valores obtidos da consulta da banco, os quais possuem o prefixo nomedaclasse_
     * 
     * @param ReflectionClass $ref
     * @return array $results[] 
     */
    private function getPropertiesInfo(ReflectionClass $ref): array
    {
        $className = strtolower($ref->getShortName());
        $properties = $ref->getProperties();
        $result = [];

        foreach ($properties as $prop) {            
            $result[] = ['name' => $className . '_' . $prop->getName(), 'type' => $prop->getType()->getName()];
        }
        
        return $result;
    }
}