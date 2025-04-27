<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ListConfEmails
 *
 * @author Celke
 */
class ListConfEmails
{

    private $dados;
    private $pag;

    public function index($pag = null) {

        $this->pag = (int) $pag ? $pag : 1;

        $listConfEmails = new \App\adms\Models\AdmsListConfEmails();
        $listConfEmails->listConfEmails($this->pag);
        if ($listConfEmails->getResultado()) {
            $this->dados['listConfEmails'] = $listConfEmails->getResultadoBd();
            $this->dados['pagination'] = $listConfEmails->getResultPg();
        } else {
            $this->dados['listConfEmails'] = [];
            $this->dados['pagination'] = null;
        }
        $this->dados['sidebarActive'] = "list-conf-emails";
        $carregarView = new \App\adms\core\ConfigView("adms/Views/confEmails/listConfEmails", $this->dados);
        $carregarView->renderizar();
    }

}
