<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of Sair
 *
 * @author Celke
 */
class Sair
{

    public function index() {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_nickname'], $_SESSION['user_email'], $_SESSION['user_image']);
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Deslogado com sucesso!</div>";        
        $urlDestino = URLADM . "login/index";
        header("Location: $urlDestino");
    }

}
