<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsConfEmail
 *
 * @author Celke
 */
class AdmsConfEmail 
{

    private $resultadoBd;
    private bool $resultado;
    private string $chave;
    private array $saveData;

    function getResultado() {
        return $this->resultado;
    }

    public function confEmail($chave) {
        $this->chave = $chave;

        $viewChaveConfEmail = new \App\adms\Models\helper\AdmsRead();
        $viewChaveConfEmail->fullRead("SELECT id
                FROM adms_users
                WHERE conf_email =:conf_email
                LIMIT :limit",
                "conf_email={$this->chave}&limit=1");

        $this->resultadoBd = $viewChaveConfEmail->getResult();
        if ($this->resultadoBd) {
            $this->updateSitUser();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido!</div>";
            $this->resultado = false;
        }
    }

    private function updateSitUser() {
        $this->saveData['conf_email'] = null;
        $this->saveData['adms_sits_user_id'] = 1;
        $this->saveData['modified'] = date("Y-m-d H:i:s");

        $up_conf_email = new \App\adms\Models\helper\AdmsUpdate();
        $up_conf_email->exeUpdate("adms_users", $this->saveData, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");

        if ($up_conf_email->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail ativado com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Link inválido!</div>";
            $this->resultado = false;
        }
    }

}
