<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsCreate
 *
 * @author Celke
 */
class AdmsCreate extends AdmsConn
{

    private string $table;
    private array $data;
    private string $result;
    private object $insert;
    private string $query;
    private object $conn;
    
    function getResult(): string {
        return $this->result;
    }
    
    public function exeCreate($table, array $data): void {
        $this->table = (string) $table;
        $this->data = $data;
        $this->exeReplaceValues();
        $this->exeIntruction();
    }

    private function exeReplaceValues(): void {
        $coluns = implode(', ', array_keys($this->data));
        $values = ':' . implode(', :', array_keys($this->data));
        $this->query = "INSERT INTO {$this->table} ($coluns) VALUES ($values)";
    }

    private function exeIntruction(): void {
        $this->connection();
        try {
            $this->insert->execute($this->data);
            $this->result = $this->conn->lastInsertId();
        } catch (Exception $ex) {
            $this->result = null;
        }
    }

    private function connection() {
        $this->conn = $this->connect();
        $this->insert = $this->conn->prepare($this->query);
    }

}
