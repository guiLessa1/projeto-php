<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AddUsers
 *
 * @author Celke
 */
class AddUsers
{

    private $dados;
    private $dadosForm;

    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddUser'])) {
            unset($this->dadosForm['AddUser']);
            $addUser = new \App\adms\Models\AdmsAddUsers();
            $addUser->create($this->dadosForm);
            if ($addUser->getResultado()) {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddUser();
            }
        } else {
            $this->viewAddUser();
        }
    }

    private function viewAddUser() {
        $listSelect = new \App\adms\Models\AdmsAddUsers();
        $this->dados['select'] = $listSelect->listSelect();
        
        $this->dados['sidebarActive'] = "list-users";

        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/addUser", $this->dados);
        $carregarView->renderizar();
    }

}
