<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of DeleteColors
 *
 * @author Celke
 */
class DeleteColors
{

    private $id;

    public function index($id = null) {
        $this->id = (int) $id;
        
        if(!empty($this->id)){
            $deleteColors = new \App\adms\Models\AdmsDeleteColors();
            $deleteColors->deleteColors($this->id);
        }else{
            $_SESSION['msg'] = "Erro: Necessário selecionar uma cor!";
        }
        
        $urlDestino = URLADM . "list-colors/index";
        header("Location: $urlDestino");
    }

}
