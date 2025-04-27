<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsViewUsers
 *
 * @author Celke
 */
class AdmsViewUsers
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

    public function viewUser($id) {
        $this->id = (int) $id;
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT usu.id, usu.name, usu.nickname, usu.email, usu.username, usu.image,
                sit.name name_sit,
                cor.color
                FROM adms_users usu
                LEFT JOIN adms_sits_users AS sit ON sit.id=usu.adms_sits_user_id
                LEFT JOIN adms_colors AS cor ON cor.id=sit.adms_color_id
                WHERE usu.id=:id
                LIMIT :limit", "id={$this->id}&limit=1");
                
        $this->resultadoBd = $viewUser->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado</div>";
            $this->resultado = false;
        }
    }

}
