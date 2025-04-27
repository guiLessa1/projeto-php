<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ListSitsUsers
 *
 * @author Celke
 */
class ListSitsUsers
{

    private $dados;
    private $pag;

    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listSitsUsers = new \App\adms\Models\AdmsListSitsUsers();
        $listSitsUsers->listSitsUsers($this->pag);
        if ($listSitsUsers->getResultado()) {
            $this->dados['listSitsUsers'] = $listSitsUsers->getResultadoBd();
            $this->dados['pagination'] = $listSitsUsers->getResultPg();
        } else {
            $this->dados['listSitsUsers'] = [];
            $this->dados['pagination'] = null;
        }

        $this->dados['sidebarActive'] = "list-sits-users";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/sitsUser/listSitsUsers", $this->dados);
        $carregarView->renderizar();
    }

}
