<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsEditConfEmailsPass
 *
 * @author Celke
 */
class AdmsEditConfEmailsPass
{

    private $resultadoBd;
    private bool $resultado;
    private int $id;
    private array $dados;

    function getResultado(): bool {
        return $this->resultado;
    }

    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewConfEmailsPass($id) {
        $this->id = (int) $id;
        $viewConfEmailsPass = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmailsPass->fullRead("SELECT id
                FROM adms_confs_emails
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewConfEmailsPass->getResult();
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não encontrado!</div>";
            $this->resultado = false;
        }
    }

    public function update(array $dados) {
        $this->dados = $dados;
        var_dump($this->dados);

        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    }

    private function edit() {
        $this->dados['modified'] = date("Y-m-d H:i:s");

        $upConfEmailsPass = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmailsPass->exeUpdate("adms_confs_emails", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");

        if ($upConfEmailsPass->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha do e-mail editado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Senha do e-mail não editado com sucesso!</div>";
            $this->resultado = false;
        }
    }

}
