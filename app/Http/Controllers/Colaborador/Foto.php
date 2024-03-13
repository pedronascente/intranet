<?php 

namespace App\Http\Controllers\Colaborador;

class Foto{

  private $path;
  private $requestImagem;
  private $extension;
  /**
   * Realiza o upload de uma foto.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string|false
   */
  public function upload($request, $path)
  {
    $this->path = $path;

    if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
      $this->requestImagem = $request->foto;
      $this->extension = $this->requestImagem->extension();
      $imagemName = $this->gerarNovoNomeDaFoto();
      $this->requestImagem->move(public_path($this->path), $imagemName);
      return $imagemName;
    }
    return false;
  }

  private function  gerarNovoNomeDaFoto()
  {
   return  md5($this->requestImagem->getClientOriginalName() . strtotime('now')) . '.' . $this->extension;
  }

}