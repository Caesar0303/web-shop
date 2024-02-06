<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'ad_id',
    ];

    public function ad() {
        return $this->belongsTo(Ad::class, 'ad_id');
    }

    use HasFactory;
}
