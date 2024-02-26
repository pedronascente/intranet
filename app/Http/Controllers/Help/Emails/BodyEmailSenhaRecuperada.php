<?php

namespace App\Http\Controllers\Help\Emails;

class BodyEmailSenhaRecuperada
{
  private $usuario; 
  private $tokens; 

  public function __construct($usuario)
  {
    $this->usuario = $usuario;
    $this->tokens = $usuario->tokens;
  }

  public function getBody()
  {
    $nome = $this->usuario->name;
    $html = "<!doctype html>";
    $html .= "<html>";
    $html .= "<head>";
    $html .= "<meta charset='utf-8'>";
    $html .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
    $html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
    $html .= "<title>Laravel - Resultados</title>";
    $html .= "</head>";
    $html .= "<body>";
    $html = "<h1>Sua Senha foi alterada!</h1>";
    $html .= "<p>Olá, " . $nome . "</p>";
    $html .= "<p>Sua senha cadastrada na Intranet foi alterada.</p>";
    $html .= "<p>Segue seus novos tokens de acesso:</p>";
    $html .=  $this->getTokens();
    $html .= "<p>*Caso não tenha pedido esssa Alteração, entre em contato com";
    $html .= " o suporte o mais rápido possivel.</p>";
    $html .= "</body>";
    $html .= "</html>";
    return  $html;
    
  }

  private function getTokens()
  {
      if(count($this->tokens)<=0){
        return null;
      }
      $html_table = '<table border="0" style="width:300px;">';
      $html_table .= '<tr class="text-center">';
      $html_table .= '<td><b>Token:</b></td>';
      $html_table .= '<td><b>Posição:</b></td>';
      $html_table .= '</tr>';
      foreach ($this->tokens as $token) {
          $html_table .= '<tr class="text-center">';
          $html_table .= '<td>' . $token->token . '</td>';
          $html_table .= '<td>' . $token->posicao . '</td>';
          $html_table .= '</tr>';
      }
      $html_table .= '</table>';
      return  $html_table;
  }
}