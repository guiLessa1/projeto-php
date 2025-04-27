<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsListColors
 *
 * @author Celke
 */
class AdmsListColors 
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
    
    public function listColors($pag = null) {
        
        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-colors/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(cor.id) AS num_result FROM adms_colors cor");
        $this->resultPg = $paginacao->getResult();

        $listColors = new \App\adms\Models\helper\AdmsRead();
        $listColors->fullRead("SELECT id, name, color
                FROM adms_colors
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listColors->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum cor encontrada!</div>";
            $this->resultado = false;
        }
    }
}
