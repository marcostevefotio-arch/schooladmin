<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ["titre_role", "description_role"];

    public function permission(){
        return $this->belongsToMany(Permission::class, "permission_roles")->withTimestamps();;
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
