<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ListColors
 *
 * @author Celke
 */
class ListColors
{

    private $dados;
    private $pag;

    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listColors = new \App\adms\Models\AdmsListColors();
        $listColors->listColors($this->pag);
        if ($listColors->getResultado()) {
            $this->dados['listColors'] = $listColors->getResultadoBd();
            $this->dados['pagination'] = $listColors->getResultPg();
        } else {
            $this->dados['listColors'] = [];
            $this->dados['pagination'] = null;
        }
        
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/listColors", $this->dados);
        $carregarView->renderizar();
    }

}
