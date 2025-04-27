<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of EditPerfilPassword
 *
 * @author Celke
 */
class EditPerfilPassword
{

    private $dadosForm;
    private $dados;

    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->dadosForm['EditPerfilPass'])) {
            $this->editPerfilPass();
        } else {
            $viewPerfilPass = new \App\adms\Models\AdmsEditPerfilPassword();
            $viewPerfilPass->viewPerfilPassword();
            if ($viewPerfilPass->getResultado()) {
                $this->dados['form'] = $viewPerfilPass->getResultadoBd();
                $this->viewEditPerfilPass();
            } else {
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }
        }
    }

    private function viewEditPerfilPass() {        
        $this->dados['sidebarActive'] = "view-perfil";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editPerfilPassword", $this->dados);
        $carregarView->renderizar();
    }

    private function editPerfilPass() {
        if (!empty($this->dadosForm['EditPerfilPass'])) {
            unset($this->dadosForm['EditPerfilPass']);
            $editPerfil = new \App\adms\Models\AdmsEditPerfilPassword();
            $editPerfil->update($this->dadosForm);
            if ($editPerfil->getResultado()) {
                $urlDestino = URLADM . "view-perfil/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditPerfilPass();
            }
        } else {
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

}
