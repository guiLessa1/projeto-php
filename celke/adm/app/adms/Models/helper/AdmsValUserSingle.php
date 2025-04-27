<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsValUserSingle
 *
 * @author Celke
 */
class AdmsValUserSingle
{

    private string $userName;
    private $edit;
    private $id;
    private bool $resultado;
    private $resultadoBd;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function validarUserSingle($username, $edit = null, $id = null) {
        $this->userName = $username;
        $this->edit = $edit;
        $this->id = $id;

        $valUserSingle = new \App\adms\Models\helper\AdmsRead();
        if (($this->edit == true) AND (!empty($this->id))) {
            $valUserSingle->fullRead("SELECT id
                    FROM adms_users
                    WHERE (username =:username OR email =:email) AND
                    id <>:id
                    LIMIT :limit",
                    "username={$this->userName}&email={$this->userName}&id={$this->id}&limit=1");
        } else {
            $valUserSingle->fullRead("SELECT id FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->userName}&limit=1");
        }

        $this->resultadoBd = $valUserSingle->getResult();
        if (!$this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Este usuário já está cadastrado!</div>";
            $this->resultado = false;
        }
    }

}
