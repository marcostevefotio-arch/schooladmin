<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = ["codeGroupe","titre_groupe", "description_groupe"];

    public function permission(){
        return $this->belongsToMany(Permission::class);
    }

    public function personnels(){
        return $this->hasMany(Personnel::class);
    }
}
