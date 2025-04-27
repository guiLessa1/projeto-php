<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use PDO;
/**
 * Description of AdmsConn
 *
 * @author Celke
 */
class AdmsConn
{
    private string $db = "mysql";
    private string $host = HOST;
    private string $user = USER;
    private string $pass = PASS;
    private string $dbname = DBNAME;
    private int $port = PORT;
    private object $connect;
    
    protected function connect() {
        try {
            $this->connect = new PDO($this->db . ':host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname, $this->user, $this->pass);
            return $this->connect;
        } catch (Exception $ex) {
            die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM . "!<br>");
        }
    }
}
