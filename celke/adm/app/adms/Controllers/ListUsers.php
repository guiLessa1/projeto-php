<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ListUsers
 *
 * @author Celke
 */
class ListUsers
{

    private $dados;
    private $pag;

    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers($this->pag);
        if ($listUsers->getResultado()) {
            $this->dados['listUsers'] = $listUsers->getResultadoBd();
            $this->dados['pagination'] = $listUsers->getResultPg();
        } else {
            $this->dados['listUsers'] = [];
            $this->dados['pagination'] = null;
        }

        $this->dados['sidebarActive'] = "list-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/listUser", $this->dados);
        $carregarView->renderizar();
    }

}
