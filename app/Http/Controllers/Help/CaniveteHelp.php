<?php

namespace App\Http\Controllers\Help;

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

    
}
