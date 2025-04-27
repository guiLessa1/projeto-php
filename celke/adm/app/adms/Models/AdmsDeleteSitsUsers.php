<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsDeleteSitsUsers
 *
 * @author Celke
 */
class AdmsDeleteSitsUsers
{

    private bool $resultado;
    private int $id;
    private $resultadoBd;

    function getResultado(): bool {
        return $this->resultado;
    }
    
    public function deleteSitsUser($id) {
        $this->id = (int) $id;

        if ($this->viewSitsUsers() AND $this->verfUserCad()) {
            $deleteSitsUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteSitsUser->exeDelete("adms_sits_users", "WHERE id =:id", "id={$this->id}");

            if ($deleteSitsUser->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação para usuário apagado com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não apagado com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    private function viewSitsUsers() {
        $viewSitsUser = new \App\adms\Models\helper\AdmsRead();
        $viewSitsUser->fullRead("SELECT id FROM adms_sits_users
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewSitsUser->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
            return false;
        }
    }
    
    private function verfUserCad() {
        $viewUserCad = new \App\adms\Models\helper\AdmsRead();
        $viewUserCad->fullRead("SELECT id FROM adms_users WHERE adms_sits_user_id=:adms_sits_user_id LIMIT :limit", "adms_sits_user_id={$this->id}&limit=1");
        if($viewUserCad->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não pode ser apagada, há usuários cadastrados com essa situação!</div>";
            return false;
        }else{
            return true;
        }
    }

}
