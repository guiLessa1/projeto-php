<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of ViewPerfil
 *
 * @author Celke
 */
class ViewPerfil
{

    
    private $dados;

    public function index() {
        $viewPerfil = new \App\adms\Models\AdmsViewPerfil();
        $viewPerfil->viewPerfil();
        if($viewPerfil->getResultado()){
            $this->dados['perfil'] = $viewPerfil->getResultadoBd();
            $this->viewPerfil();
        }else{
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }
    
    private function viewPerfil() {
        $this->dados['sidebarActive'] = "view-perfil";
        
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/viewPerfil", $this->dados);
        $carregarView->renderizar();
    }

}
