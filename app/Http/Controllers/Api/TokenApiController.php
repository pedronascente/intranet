<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TokenApiController extends Controller
{
  private $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getPosicaoToken(Request $request)
  {
    $usuario = $this->user->find($request->user()->id);

    $posicaoToken = rand(1, $usuario->qtdToken);

    return response()->json(['posicao' => $posicaoToken]);
  }
}

