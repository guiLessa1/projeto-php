<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsDeleteUsers
 *
 * @author Celke
 */
class AdmsDeleteUsers
{

    private bool $resultado;
    private int $id;
    private $resultadoBd;
    private string $delDiretorio;
    private string $delImg;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function deleteUser($id) {
        $this->id = (int) $id;

        if ($this->viewUsers()) {
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_users", "WHERE id =:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $this->deleteImg();
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário apagado com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não apagado com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    private function viewUsers() {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, image FROM adms_users
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewUser->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            return false;
        }
    }

    private function deleteImg() {
        if ((!empty($this->resultadoBd[0]['image'])) OR ($this->resultadoBd[0]['image'] != null)) {
            $this->delDiretorio = "app/adms/assets/image/users/" . $this->resultadoBd[0]['id'];
            $this->delImg = $this->delDiretorio . "/" . $this->resultadoBd[0]['image'];
            
            if(file_exists($this->delImg)){
                unlink($this->delImg);
            }
            
            if(file_exists($this->delDiretorio)){
                rmdir($this->delDiretorio);
            }
            
        }
    }

}
