<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typeue extends Model
{
    use HasFactory;

    protected $fillable = [
        "libelletypeue",
        "descriptiontypeue"
    ];


    public function ues(){
        return $this->hasMany(Ue::class);
    }
}
