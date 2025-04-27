<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsUpdatePassword
 *
 * @author Celke
 */
class AdmsUpdatePassword
{

    private $resultadoBd;
    private bool $resultado;
    private string $chave;
    private array $saveData;
    private array $dados;

    function getResultado() {
        return $this->resultado;
    }

    public function validarChave($chave) {
        $this->chave = $chave;

        $viewChaveUpPass = new \App\adms\Models\helper\AdmsRead();
        $viewChaveUpPass->fullRead("SELECT id
                FROM adms_users
                WHERE recover_password =:recover_password
                LIMIT :limit",
                "recover_password={$this->chave}&limit=1");

        $this->resultadoBd = $viewChaveUpPass->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</div>";
            $this->resultado = false;
            return false;
        }
    }

    public function editPassword(array $dados) {
        $this->dados = $dados;
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if($valCampoVazio->getResultado()){            
            $this->valInput();
        }else{
            $this->resultado = false;
        }
    }
    
    private function valInput() {
        $valPassword= new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validarPassword($this->dados['password']);
        if($valPassword->getResultado()){
            //echo "Continuar alteração da senha<br>";
            //$this->resultado = true;
            if($this->validarChave($this->dados['chave'])){
                $this->updatePassword();
            }else{
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</div>";
            $this->resultado = false;
            }            
        }else{
            $this->resultado = false;
        }
    }
    
    private function updatePassword() {
        $this->saveData['recover_password'] = null;
        $this->saveData['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
        $this->saveData['modified'] = date("Y-m-d H:i:s");
        
        $upPassword = new \App\adms\Models\helper\AdmsUpdate();
        $upPassword->exeUpdate("adms_users", $this->saveData, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");
        if($upPassword->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha atualizada com sucesso!</div>";
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Senha não atualizada, tente novamente!</div>";
            $this->resultado = false;            
        }
        
    }

}
