<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of EditPerfilImage
 *
 * @author Celke
 */
class EditPerfilImage
{

    private $dados;
    private $dadosForm;

    public function index() {
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['EditPerfilImagem'])) {
            $this->editPerfilImage();
        } else {
            $viewPerfil = new \App\adms\Models\AdmsEditPerfilImage();
            $viewPerfil->viewPerfil();
            if ($viewPerfil->getResultado()) {
                $this->dados['form'] = $viewPerfil->getResultadoBd();
                $this->viewEditPerfilImage();
            } else {
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }
        }
    }

    private function viewEditPerfilImage() {        
        $this->dados['sidebarActive'] = "view-perfil";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editPerfilImage", $this->dados);
        $carregarView->renderizar();
    }

    private function editPerfilImage() {
        if (!empty($this->dadosForm['EditPerfilImagem'])) {
            unset($this->dadosForm['EditPerfilImagem']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            $editPerfil = new \App\adms\Models\AdmsEditPerfilImage();
            $editPerfil->update($this->dadosForm);
            if ($editPerfil->getResultado()) {
                $urlDestino = URLADM . "view-perfil/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditPerfilImage();
            }
        } else {
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

}
