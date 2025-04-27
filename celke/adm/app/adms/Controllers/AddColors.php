<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AddColors
 *
 * @author Celke
 */
class AddColors
{

    private $dados;
    private $dadosForm;

    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddColors'])) {
            unset($this->dadosForm['AddColors']);
            $addColors = new \App\adms\Models\AdmsAddColors();
            $addColors->create($this->dadosForm);
            if ($addColors->getResultado()) {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddColors();
            }
        } else {
            $this->viewAddColors();
        }
    }

    private function viewAddColors() {
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/addColors", $this->dados);
        $carregarView->renderizar();
    }

}
