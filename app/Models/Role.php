<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoleUser;
use App\Models\User;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        "role_name",
        "role_uuid",
        "description"
    ];

    public function users():belongsToMany{
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }
}
