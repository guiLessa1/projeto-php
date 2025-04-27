<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ViewConfEmails
 *
 * @author Celke
 */
class ViewConfEmails
{

    private int $id;
    private $dados;

    public function index($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $viewConfEmails = new \App\adms\Models\AdmsViewConfEmails();
            $viewConfEmails->viewConfEmails($this->id);
            if ($viewConfEmails->getResultado()) {
                $this->dados['viewConfEmails'] = $viewConfEmails->getResultadoBd();
                $this->viewConfEmails();
            } else {
                $urlDestino = URLADM . "list-conf-emails/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "E-mail não encontrado!<br>";
            $urlDestino = URLADM . "list-conf-emails/index";
            header("Location: $urlDestino");
        }
    }
    
    private function viewConfEmails() {
        $this->dados['sidebarActive'] = "list-conf-emails";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/confEmails/viewConfEmails", $this->dados);
        $carregarView->renderizar();
    }

}
