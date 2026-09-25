<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    public function inscription(){
        return $this->belongsTo(Inscription::class);
    }

    public function specialite(){
        return $this->belongsTo(Specialite::class);
    }
}
