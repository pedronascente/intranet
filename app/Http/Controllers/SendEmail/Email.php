<?php

namespace App\Http\Controllers\SendEmail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Email
{
   private $_from; 
   private $_email; 
   private $_name; 
   private $_subject; 
   private $_phpMailer; 
   protected $_html; 

   public function __construct()
   {
     $this->_phpMailer = new PHPMailer(true);
   }

   public function setFrom($from){
     $this->_from = $from;
   }

   public function setEmail($email){
     $this->_email = $email;
   }
 
   public function setName($name){
     $this->_name = $name;
   }

   public function setSubject($subject){
     $this->_subject = $subject;
   }

   public function getEmail(){
     return  $this->_email;
   }

  public function getName()
  {
    return  $this->_name;
  }

  public function getFrom()
  {
    return  $this->_from;
  }

   public abstract function corpoDoEmail();

   public function enviarEmail()
   {
    $this->_phpMailer->CharSet = "UTF-8";
    try {
      //Server configuracoes
      $this->_phpMailer->SMTPDebug = 0;
      $this->_phpMailer->isSMTP();
      //Send using SMTP
      $this->_phpMailer->Host       = env('PHP_MAILER_HOST');
      $this->_phpMailer->SMTPAuth   = true;
      $this->_phpMailer->Username   = env('PHP_MAILER_USERNAME');
      $this->_phpMailer->Password   = env('PHP_MAILER_PASSWORD');
      $this->_phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $this->_phpMailer->Port       = env('PHP_MAILER_PORT');
      //Recipients
      $this->_phpMailer->setFrom($this->_from, 'Intranet');
      $this->_phpMailer->addAddress($this->_email, $this->_name);
      //Content
      $this->_phpMailer->isHTML(true);
      $this->_phpMailer->Subject = $this->_subject;
      $this->_phpMailer->Body = $this->corpoDoEmail();
      return  $this->_phpMailer->send();
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->_phpMailer->ErrorInfo}";
    }
  }
}