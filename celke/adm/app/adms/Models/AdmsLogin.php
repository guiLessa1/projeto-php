<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsLogin
 *
 * @author Celke
 */
class AdmsLogin
{

    private array $dados;
    private $resultadoBd;
    private bool $resultado;

    function getResultado() {
        return $this->resultado;
    }

    public function login(array $dados = null) {
        $this->dados = $dados;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        //$viewUser->exeRead("adms_users", "WHERE user =:user LIMIT :limit", "user={$this->dados['user']}&limit=1");
        $viewUser->fullRead("SELECT id, name, nickname, email, password, adms_sits_user_id, image
                FROM adms_users
                WHERE username =:username OR
                email =:email
                LIMIT :limit",
                "username={$this->dados['username']}&email={$this->dados['username']}&limit=1");

        $this->resultadoBd = $viewUser->getResult();
        if ($this->resultadoBd) {
            $this->valEmailPerm();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
            $this->resultado = false;
        }
    }

    private function valEmailPerm() {
        if ($this->resultadoBd[0]['adms_sits_user_id'] == 3) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário confirmar o e-mail, solicite novo e-mail <a href='" . URLADM . "new-conf-email/index'>clique aqui</a>!</div>";
            $this->resultado = false;
        } elseif ($this->resultadoBd[0]['adms_sits_user_id'] == 5) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail descadastrado, entre em contato com a empresa!</div>";
            $this->resultado = false;
        } elseif ($this->resultadoBd[0]['adms_sits_user_id'] == 2) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail inativo, entre em contato com a empresa!</div>>";
            $this->resultado = false;
        } else {
            $this->validarSenha();
        }
    }

    private function validarSenha() {
        if (password_verify($this->dados['password'], $this->resultadoBd[0]['password'])) {
            $_SESSION['user_id'] = $this->resultadoBd[0]['id'];
            $_SESSION['user_name'] = $this->resultadoBd[0]['name'];
            $_SESSION['user_nickname'] = $this->resultadoBd[0]['nickname'];
            $_SESSION['user_email'] = $this->resultadoBd[0]['email'];
            $_SESSION['user_image'] = $this->resultadoBd[0]['image'];
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário ou senha incorreta!</div>";
            $this->resultado = false;
        }
    }

}
