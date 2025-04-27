<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ConfEmail
 *
 * @author Celke
 */
class ConfEmail
{

    private $chave;

    public function index() {
        $this->chave = filter_input(INPUT_GET, "chave", FILTER_DEFAULT);

        if (!empty($this->chave)) {
            $this->validarChave();
        } else {
            $_SESSION['msg'] = "Erro: Link inválido!";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    private function validarChave() {
        $confEmail = new \App\adms\Models\AdmsConfEmail();
        $confEmail->confEmail($this->chave);
        if ($confEmail->getResultado()) {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        } else {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

}
