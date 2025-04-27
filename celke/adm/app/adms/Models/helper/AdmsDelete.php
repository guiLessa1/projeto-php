<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsDelete
 *
 * @author Celke
 */
class AdmsDelete extends AdmsConn
{

    private string $table;
    private string $termos;
    private array $values = [];
    private string $result;
    private object $delete;
    private $query;
    private object $conn;
    
    function getResult(): string {
        return $this->result;
    }
    
    public function exeDelete($table, $termos, $parseString): void {
        $this->table = (string) $table;        
        $this->termos = (string) $termos;        
        parse_str($parseString, $this->values);
        
        $this->exeIntruction();
    }
    
    private function exeIntruction() {
        $this->query = "DELETE FROM {$this->table} {$this->termos}";
        $this->connection();
        try {
            $this->delete->execute($this->values);
            if($this->delete->rowCount() >= 1){
                $this->result = true;
            }else{
                $this->result = false;
            }            
        } catch (Exception $ex) {
            $this->result = false;
        }
    }
    
    private function connection() {
        $this->conn = $this->connect();
        $this->delete = $this->conn->prepare($this->query);
    }

    
}
