<?php

namespace App\adms\Controllers;

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of Dashboard
 *
 * @author Celke
 */
class Dashboard
{

    private $dados;
    
    public function index() {
        $this->dados['sidebarActive'] = "dashboard";
        
        $carregarView = new \App\adms\core\ConfigView("adms/Views/dashboard/home", $this->dados);
        $carregarView->renderizar();
    }

}
