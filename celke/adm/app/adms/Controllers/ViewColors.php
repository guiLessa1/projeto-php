<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ViewColors
 *
 * @author Celke
 */
class ViewColors
{

    private int $id;
    private $dados;

    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewColors = new \App\adms\Models\AdmsViewColors();
            $viewColors->viewColors($this->id);
            if ($viewColors->getResultado()) {
                $this->dados['viewColors'] = $viewColors->getResultadoBd();
                $this->viewColors();
            } else {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "Cor não encontrada!<br>";
            $urlDestino = URLADM . "list-colors/index";
            header("Location: $urlDestino");
        }
    }
    
    private function viewColors() {
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/viewColors", $this->dados);
        $carregarView->renderizar();
    }

}
