<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ViewUsers
 *
 * @author Celke
 */
class ViewUsers
{

    private int $id;
    private $dados;

    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewUser = new \App\adms\Models\AdmsViewUsers();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResultado()) {
                $this->dados['viewUser'] = $viewUser->getResultadoBd();
                $this->viewUser();
            } else {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado<br>";
            $urlDestino = URLADM . "list-users/index";
            header("Location: $urlDestino");
        }
    }
    
    private function viewUser() {
        $this->dados['sidebarActive'] = "list-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/viewUser", $this->dados);
        $carregarView->renderizar();
    }

}
