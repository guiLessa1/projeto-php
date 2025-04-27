<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of DeleteConfEmails
 *
 * @author Celke
 */
class DeleteConfEmails
{

    private $id;

    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteConfEmails = new \App\adms\Models\AdmsDeleteConfEmails();
            $deleteConfEmails->deleteConfEmails($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar um E-mail!";
        }
        
        $urlDestino = URLADM . "list-conf-emails/index";
        header("Location: $urlDestino");
    }

}
