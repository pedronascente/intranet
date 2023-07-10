<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;
    protected $fillable = [
        'status', 'nome', 'user_id'
    ];

    protected $table = 'cartoes';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tekens()
    {
        return $this->hasMany(Token::class);
    }
}
