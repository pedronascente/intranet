<?php

namespace App\Http\Controllers\SendEmail;

class EmailRespostaRecuperarSenha extends Email
{
  
  private $_token; 
  private $_table_token; 

  public function setToken($token){
      $this->_token = $token;
  }
 
  public function corpoDoEmail()
  {
    $this->_html = "<!doctype html>";
    $this->_html .= "<html>";
    $this->_html .= "<head>";
    $this->_html .= "<meta charset='utf-8'>";
    $this->_html .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
    $this->_html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
    $this->_html .= "<title>Laravel - Resultados</title>";
    $this->_html .= "</head>";
    $this->_html .= "<body>";
    $this->_html = "<h1>Sua Senha foi alterada!</h1>";
    $this->_html .= "<p>Olá, " . $this->getName() . "</p>";
    $this->_html .= "<p>Sua senha cadastrada na Intranet foi alterada.</p>";
    $this->_html .= "<p>Segue seus novos tokens de acesso:</p>";
    $this->_html .=  $this->getTokens();
    $this->_html .= "<p>*Caso não tenha pedido esssa Alteração, entre em contato com";
    $this->_html .= " o suporte o mais rápido possivel.</p>";
    $this->_html .= "</body>";
    $this->_html .= "</html>";
    return  $this->_html;
    
  }

  private function getTokens()
  {
      if(count($this->_token)<=0)
      {
        return null;
      }
      $this->_table_token = '<table border="0" style="width:300px;">';
      $this->_table_token .= '<tr class="text-center">';
      $this->_table_token .= '<td><b>Token:</b></td>';
      $this->_table_token .= '<td><b>Posição:</b></td>';
      $this->_table_token .= '</tr>';
      foreach ($this->_token as $token) 
      {
          $this->_table_token .= '<tr class="text-center">';
          $this->_table_token .= '<td>' . $token->token . '</td>';
          $this->_table_token .= '<td>' . $token->posicao . '</td>';
          $this->_table_token .= '</tr>';
      }
      $this->_table_token .= '</table>';
      return  $this->_table_token;
  }
}