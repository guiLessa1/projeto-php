<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsViewSitsUsers
 *
 * @author Celke
 */
class AdmsViewSitsUsers
{
    private $resultadoBd;
    private bool $resultado;
    private int $id;

    function getResultado(): bool {
        return $this->resultado;
    }
    
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewSitsUser($id) {
        $this->id = (int) $id;
        $viewSitsUser = new \App\adms\Models\helper\AdmsRead();
        $viewSitsUser->fullRead("SELECT sit.id, sit.name,
                cor.color
                FROM adms_sits_users sit
                LEFT JOIN adms_colors AS cor ON cor.id=sit.adms_color_id
                WHERE sit.id=:id
                LIMIT :limit", "id={$this->id}&limit=1");
                
        $this->resultadoBd = $viewSitsUser->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }

}
