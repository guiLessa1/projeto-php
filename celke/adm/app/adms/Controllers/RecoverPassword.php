<?php

namespace App\adms\Controllers;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of RecoverPassword
 *
 * @author Celke
 */
class RecoverPassword
{

    private $dados;
    private $dadosForm;

    public function index() {

        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->dadosForm['RecoverPassword'])) {
            unset($this->dadosForm['RecoverPassword']);
            $recoverPassword= new \App\adms\Models\AdmsRecoverPassword();
            $recoverPassword->recoverPassword($this->dadosForm);
            if($recoverPassword->getResultado()){
                $urlDestino = URLADM . "login/index";
                header("Location: $urlDestino");
            }else{
                $this->dados['form'] = $this->dadosForm;
                $this->viewRecoverPass();
            }            
        }else{
            $this->viewRecoverPass();
        }
    }
    
    private function viewRecoverPass() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/recoverPassword", $this->dados);
        $carregarView->renderizarLogin();
    }

}
