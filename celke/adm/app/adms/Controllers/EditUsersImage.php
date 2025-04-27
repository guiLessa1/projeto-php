<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of EditUsersImage
 *
 * @author Celke
 */
class EditUsersImage
{

    private $dados;
    private $dadosForm;
    private $id;

    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditUserImagem']))) {
            $viewUser = new \App\adms\Models\AdmsEditUsersImage();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResultado()) {
                $this->dados['form'] = $viewUser->getResultadoBd();
                $this->viewEditUserImage();
            } else {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editUser();
        }
    }

    private function viewEditUserImage() {
        $this->dados['sidebarActive'] = "list-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editUserImage", $this->dados);
        $carregarView->renderizar();
    }

    private function editUser() {
        if (!empty($this->dadosForm['EditUserImagem'])) {
            unset($this->dadosForm['EditUserImagem']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] ? $_FILES['new_image'] : null);
            //var_dump($this->dadosForm);
            $editUser = new \App\adms\Models\AdmsEditUsersImage();
            $editUser->update($this->dadosForm);
            if ($editUser->getResultado()) {
                $urlDestino = URLADM . "view-users/index/" . $this->dadosForm['id'];
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditUserImage();
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $urlDestino = URLADM . "list-users/index";
            header("Location: $urlDestino");
        }
    }

}
