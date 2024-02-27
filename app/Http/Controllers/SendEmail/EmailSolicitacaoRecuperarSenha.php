<?php

namespace App\Http\Controllers\SendEmail;

class EmailSolicitacaoRecuperarSenha extends Email
{
  public $_tokenResetPass;
  private $_link;
 
  public function setTokenResetPass($tokenResetPass){
     $this->_tokenResetPass = $tokenResetPass;
  }
  
  public function getTokenResetPass(){
     return $this->_tokenResetPass;
  }

  public function setLink($rota)
  {
    $this->_link = route($rota, [$this->getEmail(), $this->getTokenResetPass()]);
  }

  public function getLink(){
    return $this->_link;
  }
  
  public function corpoDoEmail()
  {
    $this->_html = "<!doctype html>";
    $this->_html .= "<html>";
    $this->_html .= "<head>";
    $this->_html .= "<meta charset='utf-8'>";
    $this->_html .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
    $this->_html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
    $this->_html .= "<title>Recuperar minha Senha</title>";
    $this->_html .= "</head>";
    $this->_html .= "<body>";
    $this->_html .= "<p>presado(a) " . $this->getName() . "</p>";
    $this->_html .= "<p>Recebemos em nosso sistema uma solicitação para recuperar sua senha </p>";
    $this->_html .= "<p>Por favor, caso não tenha solicitado favor, ignore este email. caso contrario ...</p>";
    $this->_html .= "
              <h1>Super Dicas para uma boa senha!</h1>
                  <ul>
                      <li>deve ter pelo menos 6 caracteres: [ min:6 ]</li>
                      <li>deve conter pelo menos uma letra minúscula: [a-z]</li>
                      <li>deve conter pelo menos uma letra maiúscula: [A-Z]</li>
                      <li>deve conter pelo menos um dígito: [0-9]</li>
                      <li>deve conter um caractere especial:[@$!%*#?&]</li>
                  </ul>";
    $this->_html .= "
                  <br>
                  <p>
                      <a href=" . $this->getLink() . " >CLIQUE AQUI PARA RECUPERAR SUA SENHA</a>
                  </p>";
    $this->_html .= "</body>";
    $this->_html .= "</html>";
    return $this->_html;
  }
}

/*
  *****************************************************************************
  xDebug :
  *****************************************************************************

  $e = new EmailSolicitacaoRecuperarSenha();
  $e->setFrom("desenvolvimento@grupovolpato.com");
  $e->setName($objetoModel->nome);
  $e->setEmail($objetoModel->email);
  $e->setSubject('Recuperar Senha');
  $e->setTokenResetPass($objetoModel->token_reset_pass);
  $e->setLink('recuperarSenha.cadastrarNovaSenha');

  echo $e->corpoDoEmail();

*/