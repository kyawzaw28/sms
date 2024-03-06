<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function classitems()
    {
        return $this->belongsToMany(Classitem::class, 'classitem_students')->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
