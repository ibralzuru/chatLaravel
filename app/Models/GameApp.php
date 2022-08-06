<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameApp extends Model
{
    use HasFactory;

    public function party(){
        return $this->hasMany(Party::class);
    }
}
