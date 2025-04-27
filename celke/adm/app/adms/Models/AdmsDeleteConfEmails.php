<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsDeleteConfEmails
 *
 * @author Celke
 */
class AdmsDeleteConfEmails
{

    private bool $resultado;
    private int $id;
    private $resultadoBd;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function deleteConfEmails($id) {
        $this->id = (int) $id;

        if ($this->viewConfEmails()) {
            $deleteConfEmails = new \App\adms\Models\helper\AdmsDelete();
            $deleteConfEmails->exeDelete("adms_confs_emails", "WHERE id =:id", "id={$this->id}");

            if ($deleteConfEmails->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail apagado com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não apagado com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    private function viewConfEmails() {
        $viewConfEmails = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmails->fullRead("SELECT id FROM adms_confs_emails
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewConfEmails->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não encontrado!</div>";
            return false;
        }
    }

}
