<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'number',
        'city',
        'state',
        'address',
        'phone',
        'established_at',
    ];

    public function guardians(): HasMany
    {
        return $this->hasMany(Guardian::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
