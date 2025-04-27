<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ViewSitsUsers
 *
 * @author Celke
 */
class ViewSitsUsers
{

    private int $id;
    private $dados;

    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewSitsUser = new \App\adms\Models\AdmsViewSitsUsers();
            $viewSitsUser->viewSitsUser($this->id);
            if ($viewSitsUser->getResultado()) {
                $this->dados['viewSitsUser'] = $viewSitsUser->getResultadoBd();
                $this->viewSitsUser();
            } else {
                $urlDestino = URLADM . "list-sits-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "Situação para usuário não encontrado<br>";
            $urlDestino = URLADM . "list-sits-users/index";
            header("Location: $urlDestino");
        }
    }
    
    private function viewSitsUser() {
        $this->dados['sidebarActive'] = "list-sits-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/sitsUser/viewSitsUser", $this->dados);
        $carregarView->renderizar();
    }

}
