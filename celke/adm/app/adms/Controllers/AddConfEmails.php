<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AddConfEmails
 *
 * @author Celke
 */
class AddConfEmails
{

    private $dados;
    private $dadosForm;

    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['AddConfEmails'])) {
            unset($this->dadosForm['AddConfEmails']);
            $addConfEmails = new \App\adms\Models\AdmsAddConfEmails();
            $addConfEmails->create($this->dadosForm);
            if ($addConfEmails->getResultado()) {
                $urlDestino = URLADM . "list-conf-emails/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddConfEmails();
            }
        } else {
            $this->viewAddConfEmails();
        }
    }

    private function viewAddConfEmails() {
        $this->dados['sidebarActive'] = "list-conf-emails";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/confEmails/addConfEmails", $this->dados);
        $carregarView->renderizar();
    }

}
