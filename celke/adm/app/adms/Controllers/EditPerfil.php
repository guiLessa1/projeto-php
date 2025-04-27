<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of EditPerfil
 *
 * @author Celke
 */
class EditPerfil
{
    private $dadosForm;
    private $dados;
    
    public function index() {
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(!empty($this->dadosForm['EditPerfil'])){
            $this->editPerfil();
        }else{
            $viewPerfil = new \App\adms\Models\AdmsEditPerfil();
            $viewPerfil->viewPerfil();
            if($viewPerfil->getResultado()){
                $this->dados['form'] = $viewPerfil->getResultadoBd();
                $this->viewEditPerfil();
            }else{
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
                       
            }
        }        
    }
    
    private function viewEditPerfil() {        
        $this->dados['sidebarActive'] = "view-perfil";
        $carregarView= new \App\adms\core\ConfigView("adms/Views/user/editPerfil", $this->dados);
        $carregarView->renderizar();
    }
    
    private function editPerfil() {
        if(!empty($this->dadosForm['EditPerfil'])){
            unset($this->dadosForm['EditPerfil']);
            $editPerfil = new \App\adms\Models\AdmsEditPerfil();
            $editPerfil->update($this->dadosForm);
            if($editPerfil->getResultado()){
                $urlDestino = URLADM . "view-perfil/index";
                header("Location: $urlDestino");
            }else{
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditPerfil();
            }
        }else{
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br>";
            $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
        }
    }
}
