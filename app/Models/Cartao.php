<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
    ];
    protected $table = 'cartoes';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
