<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        "city",
        "city_ascii",
        "lat",
        "lng",
        "country",
    ];


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
