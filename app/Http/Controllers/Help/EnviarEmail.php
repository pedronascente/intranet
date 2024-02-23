<?php

namespace App\Http\Controllers\Help;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EnviarEmail
{
  private $from;
  private $email;
  private $nome;
  private $body;

  public function __construct()
  {
    $this->from = "desenvolvimento@grupovolpato.com";
  }

  public function setEmail($email){
      $this->email = $email;
  } 

  public function setNome($nome){
      $this->nome = $nome;
  } 

  public function setBody($body){
      $this->body = $body;
  } 

  public function enviarEmail()
  {
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";
    try {
      //Server configuracoes
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      //Send using SMTP
      $mail->Host       = env('PHP_MAILER_HOST');
      $mail->SMTPAuth   = true;
      $mail->Username   = env('PHP_MAILER_USERNAME');
      $mail->Password   = env('PHP_MAILER_PASSWORD');
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port       = env('PHP_MAILER_PORT');
      //Recipients
      $mail->setFrom($this->from, 'Intranet');
      $mail->addAddress($this->email, $this->nome);
      //Content
      $mail->isHTML(true);
      $mail->Subject = 'Recuperar Senha';
      $mail->Body = $this->body;
      return  $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}