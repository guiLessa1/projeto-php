<?php

namespace App\adms\Models;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsListUsers
 *
 * @author Celke
 */
class AdmsListUsers
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

    
    public function listUsers($pag = null) {

        $this->pag = (int) $pag;
        $paginacao = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index');
        $paginacao->condition($this->pag, $this->limitResult);
        $paginacao->pagination("SELECT COUNT(usu.id) AS num_result FROM adms_users usu");
        $this->resultPg =$paginacao->getResult();
        
        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("SELECT usu.id, usu.name, usu.email,
                sit.name name_sit,
                cor.color
                FROM adms_users usu
                LEFT JOIN adms_sits_users AS sit ON sit.id=usu.adms_sits_user_id
                LEFT JOIN adms_colors AS cor ON cor.id=sit.adms_color_id
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$paginacao->getOffset()}");

        $this->resultadoBd = $listUsers->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontrado!</div>";
            $this->resultado = false;
        }
    }

}
