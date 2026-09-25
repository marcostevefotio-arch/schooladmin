<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $table = "matieres";
    protected $primaryKey = "id";

    public function ues(){
        return $this->belongsTo(Ue::class, "ue_id");
    }

    public function enseignantMatiere(){
        return $this->hasMany(Enseignantmatiere::class);
    }

    public function cours(){
        return $this->hasMany(Cour::class);
    }

    public function syllabus(){
        return $this->hasMany(Syllabus::class);
    }


    public function notes(){
        return $this->hasMany(Note::class);
    }
    
    
    protected static function booted () {
        static::deleting(function(Matiere $matiere) { // before delete() method call this
             $matiere->syllabus()->delete();
             // do the rest of the cleanup...
        });
    }
}
