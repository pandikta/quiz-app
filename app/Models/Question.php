<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'answer',
        'score'
    ];

    protected $hidden = ['id'];
    protected $primaryKey = 'id';
}
