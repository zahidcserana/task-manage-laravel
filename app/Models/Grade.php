<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
    ];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
