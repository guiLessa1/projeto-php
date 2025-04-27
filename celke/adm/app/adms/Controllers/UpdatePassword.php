<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of UpdatePassword
 *
 * @author Celke
 */
class UpdatePassword
{

    private $chave;
    private $dadosForm;

    public function index() {
        $this->chave = filter_input(INPUT_GET, "chave", FILTER_DEFAULT);
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->chave) AND empty($this->dadosForm['UpPassword'])) {
            $this->validarChave();
        } else {
            $this->updatePasword();
        }
    }

    private function validarChave() {
        $valChave = new \App\adms\Models\AdmsUpdatePassword();
        $valChave->validarChave($this->chave);
        if ($valChave->getResultado()) {
            $this->viewUpdatePassword();
        } else {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    private function updatePasword() {
        if (!empty($this->dadosForm['UpPassword'])) {
            unset($this->dadosForm['UpPassword']);
            $this->dadosForm['chave'] = $this->chave;
            $upPassword = new \App\adms\Models\AdmsUpdatePassword();
            $upPassword->editPassword($this->dadosForm);
            if ($upPassword->getResultado()) {
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            } else {
                $this->viewUpdatePassword();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido, solicite novo link<a href='" . URLADM . "recover-password/index'>clique aqui!</div>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    private function viewUpdatePassword() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/updatePassword");
        $carregarView->renderizarLogin();
    }

}
