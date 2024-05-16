<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    use HasFactory;
    protected $fillable = [
        "file_name",
        "description",
        "file_url",
        "upload_by",
        "file_ext",
    ];
}
