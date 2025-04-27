<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of DeleteUsers
 *
 * @author Celke
 */
class DeleteUsers
{

    private $id;

    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteUser = new \App\adms\Models\AdmsDeleteUsers();
            $deleteUser->deleteUser($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um usuário!";
        }
        
        $urlDestino = URLADM . "list-users/index";
        header("Location: $urlDestino");
    }

}
