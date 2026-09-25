<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organigramme extends Model
{
    use HasFactory;

    public function parent(){
        return $this->hasMany(Organigramme::class, "organisation_id");
    }

    public function enfants(){
        return $this->belongsTo(Organigramme::class, "organisation_id");
    }
}
