<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Description of AdmsSendEmail
 *
 * @author Celke
 */
class AdmsSendEmail
{

    private array $dados;
    private array $dadosInfoEmail;
    private array $resultadoBd;
    private bool $resultado;
    private string $fromEmail;
    private int $optionConfEmail;

    function getResultado(): bool {
        return $this->resultado;
    }

    function getFromEmail(): string {
        return $this->fromEmail;
    }

    public function sendEmail($dados, $optionConfEmail) {
        $this->optionConfEmail = $optionConfEmail;
        $this->dados = $dados;
        $this->infoPhpMailer();
        $this->sendEmailPhpMailer();
    }

    private function infoPhpMailer() {
        $confEmail = new \App\adms\Models\helper\AdmsRead();
        $confEmail->fullRead("SELECT name, email, host, username, password, smtpsecure, port FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id={$this->optionConfEmail}&limit=1");
        $this->resultadoBd = $confEmail->getResult();
        
        $this->dadosInfoEmail['host'] = $this->resultadoBd[0]['host'];
        $this->dadosInfoEmail['fromEmail'] = $this->resultadoBd[0]['email'];
        $this->fromEmail = $this->dadosInfoEmail['fromEmail'];
        $this->dadosInfoEmail['fromName'] = $this->resultadoBd[0]['name'];
        $this->dadosInfoEmail['username'] = $this->resultadoBd[0]['username'];
        $this->dadosInfoEmail['password'] = $this->resultadoBd[0]['password'];
        $this->dadosInfoEmail['smtpsecure'] = $this->resultadoBd[0]['smtpsecure'];
        $this->dadosInfoEmail['port'] = $this->resultadoBd[0]['port'];
    }

    private function sendEmailPhpMailer() {
        $mail = new PHPMailer(true);
        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = $this->dadosInfoEmail['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->dadosInfoEmail['username'];
            $mail->Password = $this->dadosInfoEmail['password'];
            $mail->SMTPSecure = $this->dadosInfoEmail['smtpsecure'];
            $mail->Port = $this->dadosInfoEmail['port'];

            $mail->setFrom($this->dadosInfoEmail['fromEmail'], $this->dadosInfoEmail['fromName']);
            $mail->addAddress($this->dados['toEmail'], $this->dados['toName']);

            $mail->isHTML(true);
            $mail->Subject = $this->dados['subject'];
            $mail->Body = $this->dados['contentHtml'];
            $mail->AltBody = $this->dados['contentText'];

            $mail->send();
            $this->resultado = true;
        } catch (Exception $ex) {
            $this->resultado = false;
        }
    }

}
