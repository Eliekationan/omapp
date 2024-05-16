<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $fillable = [
        'folder_name',
        'description',
        'created_by',
        'mark_as_favorite',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsToMany(User::class)->using(FileUser::class);
    }
}
