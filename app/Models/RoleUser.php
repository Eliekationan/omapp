<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    public $incrementing = true;
    use HasFactory;
    protected $fillable = ["active", "created_at", "updated_at"];
}
