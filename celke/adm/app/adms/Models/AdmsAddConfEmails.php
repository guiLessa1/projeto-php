<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsAddConfEmails
 *
 * @author Celke
 */
class AdmsAddConfEmails
{

    private array $dados;
    private bool $resultado;

    function getResultado() {
        return $this->resultado;
    }

    public function create(array $dados = null) {
        $this->dados = $dados;
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->add();
        } else {
            $this->resultado = false;
        }
    }

    private function add() {
        $this->dados['created'] = date("Y-m-d H:i:s");
        
        $createConfEmail = new \App\adms\Models\helper\AdmsCreate();
        $createConfEmail->exeCreate("adms_confs_emails", $this->dados);

        if ($createConfEmail->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail cadastrado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não cadastrado com sucesso. Tente mais tarde!</div>";
            $this->resultado = false;
        }
    }

}
