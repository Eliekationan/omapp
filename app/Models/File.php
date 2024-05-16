<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FileUser;
class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'folder_id',
        'file_name',
        'description',
        'file_url',
        'upload_by',
        'file_ext',
        'mark_as_favorite',
        'shared',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsToMany(User::class)->using(FileUser::class);
    }
}
