<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of DeleteSitsUsers
 *
 * @author Celke
 */
class DeleteSitsUsers
{

    private $id;

    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteSitsUser = new \App\adms\Models\AdmsDeleteSitsUsers();
            $deleteSitsUser->deleteSitsUser($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar uma situação para usuário!";
        }
        
        $urlDestino = URLADM . "list-sits-users/index";
        header("Location: $urlDestino");
    }

}
