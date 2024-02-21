<?php

namespace App\Http\Controllers\Help;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
class CaniveteHelp
{
    public static function formatarDataLogin()
    {
        $horaAtual = now()->format('H');

        if ($horaAtual >= 19) {
          $ret = 'Boa Noite';
        } else if ($horaAtual <= 18 &&  $horaAtual >= 12) {
          $ret = 'Boa Tarde';
        } else {
          $ret = 'Bom Dia';
        }
        return $ret;
    }

    public static function generateSlug($word)
    {
        // replace non letter or digits by divider
        $slug = preg_replace('~[^\pL\d]+~u', '-', $word);

        // transliterate
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

        // remove unwanted characters
        $slug = preg_replace('~[^-\w]+~', '', $slug);

        // trim
        $slug = trim($slug, '-');

        // remove duplicate divider
        $slug = preg_replace('~-+~', '-', $slug);

        // lowercase
        $slug = strtolower($slug);

        if (empty($slug)) {
          return 'n-a';
        }
        return $slug;
    }

    public static function formatarDataAnoMesDia($dataEntrada)
    {
        // Verificar se a barra está presente na string
        if (strpos($dataEntrada, '/') === false) {
          // Se não houver barra, retornar false
          return false;
        }
        // Quebrar a data em dia, mês e ano
        list($dia, $mes, $ano) = explode("/", $dataEntrada);
        // Formatar a data no formato desejado: "2023/04/06"
        $dataFormatada = $ano . "-" . $mes . "-" . $dia;
        // Saída da data formatada
        return $dataFormatada;
    }

    /**
     * Realiza o upload de uma foto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|false
     */
    public function upload($request, $path)
    {
      if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
        $requestImagem  = $request->foto;
        $extension      = $requestImagem->extension();
        $imagemName     = md5($requestImagem->getClientOriginalName() . strtotime('now')) . '.' . $extension;
        $requestImagem->move(public_path($path), $imagemName);
        return $imagemName;
      }
      return false;
    }
    
     public function enviarEmail($arrayDosDadosDeEnvio){

        $emailFfrom = $arrayDosDadosDeEnvio['emailFfrom'];
        $email = $arrayDosDadosDeEnvio['email'];
        $nome = $arrayDosDadosDeEnvio['nome'];
        $body = $arrayDosDadosDeEnvio['body'];

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        try {
          //Server configuracoes
          $mail->SMTPDebug = 0;                      //Enable verbose debug output
          $mail->isSMTP();
          //Send using SMTP
          $mail->Host       = env('PHP_MAILER_HOST');                     //Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          $mail->Username   = env('PHP_MAILER_USERNAME');;                     //SMTP username
          $mail->Password   = env('PHP_MAILER_PASSWORD');                               //SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = env('PHP_MAILER_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
          //Recipients
          $mail->setFrom($emailFfrom, 'Intranet');
          $mail->addAddress($email, $nome);     //Add a recipient
          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Recuperar Senha';
          $mail->Body = $body;
          $mail->send();
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
     }

}
