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
}
