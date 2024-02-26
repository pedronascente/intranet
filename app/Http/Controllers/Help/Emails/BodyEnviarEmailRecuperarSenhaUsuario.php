<?php

namespace App\Http\Controllers\Help\Emails;

class BodyEnviarEmailRecuperarSenhaUsuario
{
  private $colaborador; 

  public function __construct($colaborador)
  {
    $this->colaborador = $colaborador;
  }

  public function getBody()
  {
    $nome = $this->colaborador->nome;
    $email = $this->colaborador->email;
    $token_reset_pass = $this->colaborador->token_reset_pass;

    $link = route('recuperarSenha.cadastrarNovaSenha', [$email, $token_reset_pass]);
    $html = "<!doctype html>";
    $html .= "<html>";
    $html .= "<head>";
    $html .= "<meta charset='utf-8'>";
    $html .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
    $html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
    $html .= "<title>Recuperar minha Senha</title>";
    $html .= "</head>";
    $html .= "<body>";
    $html .= "<p>presado(a) " . $nome . "</p>";
    $html .= "<p>Recebemos em nosso sistema uma solicitação para recuperar sua senha </p>";
    $html .= "<p>Por favor, caso não tenha solicitado favor, ignore este email. caso contrario ...</p>";
    $html .= "
              <h1>Super Dicas para uma boa senha!</h1>
                  <ul>
                      <li>deve ter pelo menos 6 caracteres: [ min:6 ]</li>
                      <li>deve conter pelo menos uma letra minúscula: [a-z]</li>
                      <li>deve conter pelo menos uma letra maiúscula: [A-Z]</li>
                      <li>deve conter pelo menos um dígito: [0-9]</li>
                      <li>deve conter um caractere especial:[@$!%*#?&]</li>
                  </ul>";
    $html .= "
                  <br>
                  <p>
                      <a href=" . $link . " >CLIQUE AQUI PARA RECUPERAR SUA SENHA</a>
                  </p>";
    $html .= "</body>";
    $html .= "</html>";
    return $html;
  }
}