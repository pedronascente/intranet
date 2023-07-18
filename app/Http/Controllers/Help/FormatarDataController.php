<?php

namespace App\Http\Controllers\Help;

class FormatarDataController
{

  public static function formatarData()
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
}
