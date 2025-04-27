<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsViewPerfil
 *
 * @author Celke
 */
class AdmsViewPerfil
{
    private $resultadoBd;
    private bool $resultado;

    function getResultado(): bool {
        return $this->resultado;
    }
    
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewPerfil() {
        
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, name, nickname, email, username, image 
                FROM adms_users
                WHERE id=:id
                LIMIT :limit", "id={$_SESSION['user_id']}&limit=1");
                
        $this->resultadoBd = $viewUser->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado</div>";
            $this->resultado = false;
        }
    }

}
