<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasMany(User::class);
    }

    public function groupe(){
        return $this->belongsTo(Groupe::class);
    }
}
