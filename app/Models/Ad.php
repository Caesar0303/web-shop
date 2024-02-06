<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'author_id',
        'category_id',
        'city_id',
        'header',
        'description',
        'phone_number',
        'quantity',
        'price',
        'views', // Обычно, поле views не включается в fillable, так как его значение обычно управляется приложением
        'img_1',
        'img_2',
        'img_3',
    ];

    use HasFactory;
}
