<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleQuizOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'style_quiz_question_id',
        'option_text',
        'image_url',
        'related_categories',
    ];

    public function question()
    {
        return $this->belongsTo(StyleQuizQuestion::class);
    }
}
