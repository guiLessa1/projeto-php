<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of EditUsers
 *
 * @author Celke
 */
class EditUsers
{

    private $dados;
    private $dadosForm;
    private $id;

    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditUser']))) {
            $viewUser = new \App\adms\Models\AdmsEditUsers();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResultado()) {
                $this->dados['form'] = $viewUser->getResultadoBd();
                $this->viewEditUser();
            } else {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editUser();
        }
    }

    private function viewEditUser() {
        
        //$listSelect = new \App\adms\Models\AdmsAddUsers();
        //$this->dados['select'] = $listSelect->listSelect();
        
        $listSelect = new \App\adms\Models\AdmsEditUsers();
        $this->dados['select'] = $listSelect->listSelect();        
        
        $this->dados['sidebarActive'] = "list-users";
        
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editUser", $this->dados);
        $carregarView->renderizar();
    }

    private function editUser() {
        if (!empty($this->dadosForm['EditUser'])) {
            unset($this->dadosForm['EditUser']);
            $editUser = new \App\adms\Models\AdmsEditUsers();
            $editUser->update($this->dadosForm);
            if ($editUser->getResultado()) {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditUser();
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $urlDestino = URLADM . "list-users/index";
            header("Location: $urlDestino");
        }
    }

}
