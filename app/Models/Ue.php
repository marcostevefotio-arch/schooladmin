<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ue extends Model
{
    use HasFactory;
    protected $table = "ues";
    protected $primaryKey ="id";

    public function matiere(){
        return $this->hasMany(Matiere::class);
    }
    public function typeue(){
        return $this->belongsTo(Typeue::class);
    }

    public function semestre(){
        return $this->belongsTo(Semestre::class);
    }

    public function specialite(){
        return $this->belongsTo(Specialite::class);
    }
    
    protected static function booted () {
        static::deleting(function(Ue $ue) { // before delete() method call this
             $ue->matiere()->delete();
             // do the rest of the cleanup...
        });
    }
}
