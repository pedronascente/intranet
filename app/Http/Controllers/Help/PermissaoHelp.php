<?php

namespace App\Http\Controllers\Help;

class PermissaoHelp
{

  public static function verificaPermissao($data)
  {
    $permissao = $data['permissao'];
    $modulo = $data['modulo'];

    $ArrayLystPermissoes = [];
    if (session()->get('perfil')) {
      foreach (session()->get('perfil')['permissoes'] as $item) {
        foreach ($item as  $value) {
          if ($value->modulo_id == $modulo) {
            $ArrayLystPermissoes[] = $value->nome;
          };
        }
      }
    }
    if (in_array($permissao, $ArrayLystPermissoes)) {
      return true;
    } else {
      return false;
    }
  }

  public static function getPermissoes($modulo)
  {
    $p = null;
    if (session()->get('perfil')['permissoes']) {
      $permissoes = session()->get('perfil')['permissoes']->toArray();
      foreach ($permissoes as $modulokey => $value) {
        if ($modulokey == $modulo) {
          $p  = $value;
        }
      }
    }
    return $p;
  }
}
