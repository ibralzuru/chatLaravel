<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameApp extends Model
{
    use HasFactory;

    public function canal(){
        return $this->hasMany(Canal::class);
    }
    public function user(){
        return $this->belongsToMany(User::class);
    }
}
