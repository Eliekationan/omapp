<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adhesion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        "jobs_id",
        "city_id",
        "piece_id",
        "second_name",
        "birth_date",
        "adresse",
        "grade",
        "fonction",
        "nature_piece",
        "numero_piece",
        "telephone",
        "retraite",
        "secteur_activite",
        "created_at",
        "updated_at"
    ];
}
