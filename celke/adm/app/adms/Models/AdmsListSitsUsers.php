<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsListSitsUsers
 *
 * @author Celke
 */
class AdmsListSitsUsers 
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
    
    public function listSitsUsers($pag = null) {
        
        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-sits-users/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(id) AS num_result FROM adms_sits_users");
        $this->resultPg = $paginacao->getResult();

        $listSitsUsers = new \App\adms\Models\helper\AdmsRead();
        $listSitsUsers->fullRead("SELECT sit.id, sit.name,
                cor.color
                FROM adms_sits_users sit
                LEFT JOIN adms_colors AS cor ON cor.id=sit.adms_color_id
                LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listSitsUsers->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum situação para usuário encontrado!</div>";
            $this->resultado = false;
        }
    }
}
