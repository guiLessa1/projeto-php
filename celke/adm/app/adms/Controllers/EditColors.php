<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of EditColors
 *
 * @author Celke
 */
class EditColors
{

    private $dados;
    private $dadosForm;
    private $id;

    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditColors']))) {
            $viewColors = new \App\adms\Models\AdmsEditColors();
            $viewColors->viewColors($this->id);
            if ($viewColors->getResultado()) {
                $this->dados['form'] = $viewColors->getResultadoBd();
                $this->viewEditColors();
            } else {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editColors();
        }
    }

    private function viewEditColors() {               
        $this->dados['sidebarActive'] = "list-colors";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/colors/editColors", $this->dados);
        $carregarView->renderizar();
    }

    private function editColors() {
        if (!empty($this->dadosForm['EditColors'])) {
            unset($this->dadosForm['EditColors']);
            $editColors = new \App\adms\Models\AdmsEditColors();
            $editColors->update($this->dadosForm);
            if ($editColors->getResultado()) {
                $urlDestino = URLADM . "list-colors/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditColors();
            }
        } else {
            $_SESSION['msg'] = "Cor não encontrada!<br>";
            $urlDestino = URLADM . "list-colors/index";
            header("Location: $urlDestino");
        }
    }

}
