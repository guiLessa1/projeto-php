<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsEditPerfil
 *
 * @author Celke
 */
class AdmsEditPerfil
{
    private $resultadoBd;
    private bool $resultado;
    private $dadosExitVal;
    private array $dados;
    
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    function getResultado(): bool {
        return $this->resultado;
    }

    public function viewPerfil() {
        $viewPerfil = new \App\adms\Models\helper\AdmsRead();
        $viewPerfil->fullRead("SELECT id, name, nickname, email, username
                FROM adms_users
                WHERE id=:id
                LIMIT :limit ", 
                "id={$_SESSION['user_id']}&limit=1");
        $this->resultadoBd = $viewPerfil->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }
    
    public function update(array $dados) {
        $this->dados = $dados;
        
        $this->dadosExitVal['nickname'] = $this->dados['nickname'];
        unset($this->dados['nickname']);
        
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if($valCampoVazio->getResultado()){            
            $this->valInput();
        }else{
            $this->resultado = false;
        }
    }
    
    private function valInput() {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validarEmail($this->dados['email']);
        
        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validarEmailSingle($this->dados['email'], true, $_SESSION['user_id']);
        
        $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validarUserSingle($this->dados['username'], true, $_SESSION['user_id']);
        
        if($valEmail->getResultado() AND $valEmailSingle->getResultado() AND $valUserSingle->getResultado()){
            //$_SESSION['msg'] = "Continuar up";
            //$this->resultado = false;
            $this->edit();
        }else{
            $this->resultado = false;
        }
    }
    
    private function edit() {
        $this->dados['nickname'] = $this->dadosExitVal['nickname'];
        $this->dados['modified'] = date("Y-m-d H:i:s");
        
        $upPerfil = new \App\adms\Models\helper\AdmsUpdate();
        $upPerfil->exeUpdate("adms_users", $this->dados, "WHERE id=:id", "id={$_SESSION['user_id']}");
        
        if($upPerfil->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Perfil editado com sucesso!</div>";
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Perfil não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }
           
}
