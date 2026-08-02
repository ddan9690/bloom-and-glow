<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDailyLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'date',
        'max_limit',
    ];

    protected $casts = [
        'date' => 'date',
        'max_limit' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}