<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassitemStudent extends Model
{
    use HasFactory;
    
    public function classitems()
    {
        return $this->hasMany(Classitem::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }

}
