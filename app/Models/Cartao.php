<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'nome',
        'qtdToken',
        'user_id'
    ];

    protected $table = 'cartoes';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
}
