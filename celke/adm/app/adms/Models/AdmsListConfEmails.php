<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsListConfEmails
 *
 * @author Celke
 */
class AdmsListConfEmails 
{

    private $resultadoBd;
    private bool $resultado;
    private $pag;
    private $limitResult = 40;
    private $resultPg;

    function getResultado() {
        return $this->resultado;
    }
    
    function getResultadoBd() {
        return $this->resultadoBd;
    }
    
    function getResultPg() {
        return $this->resultPg;
    }
    
    public function listConfEmails($pag = null) {
        
        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-conf-emails/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(id) AS num_result FROM adms_confs_emails");
        $this->resultPg = $paginacao->getResult();

        $listConfEmails = new \App\adms\Models\helper\AdmsRead();
        $listConfEmails->fullRead("SELECT id, title, name, email
                FROM adms_confs_emails
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listConfEmails->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum e-mail encontrado!</div>";
            $this->resultado = false;
        }
    }
}
