<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleQuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'type',
        'order',
    ];

    public function options()
    {
        return $this->hasMany(StyleQuizOption::class);
    }
}
