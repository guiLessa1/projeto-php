<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of EditConfEmails
 *
 * @author Celke
 */
class EditConfEmails
{

    private $dados;
    private $dadosForm;
    private $id;

    public function index($id) {
        $this->id = (int) $id;

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->id) AND (empty($this->dadosForm['EditConfEmails']))) {
            $viewConfEmails = new \App\adms\Models\AdmsEditConfEmails();
            $viewConfEmails->viewConfEmails($this->id);
            if ($viewConfEmails->getResultado()) {
                $this->dados['form'] = $viewConfEmails->getResultadoBd();
                $this->viewEditConfEmails();
            } else {
                $urlDestino = URLADM . "list-conf-emails/index";
                header("Location: $urlDestino");
            }
        } else {
            $this->editConfEmails();
        }
    }

    private function viewEditConfEmails() {               
        $this->dados['sidebarActive'] = "list-conf-emails";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/confEmails/editConfEmails", $this->dados);
        $carregarView->renderizar();
    }

    private function editConfEmails() {
        if (!empty($this->dadosForm['EditConfEmails'])) {
            unset($this->dadosForm['EditConfEmails']);
            $editConfEmails = new \App\adms\Models\AdmsEditConfEmails();
            $editConfEmails->update($this->dadosForm);
            if ($editConfEmails->getResultado()) {
                $urlDestino = URLADM . "view-conf-emails/index/" . $this->dadosForm['id'];
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditConfEmails();
            }
        } else {
            $_SESSION['msg'] = "E-mail não encontrado!<br>";
            $urlDestino = URLADM . "list-conf-emails/index";
            header("Location: $urlDestino");
        }
    }

}
