<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classitem extends Model
{
    use HasFactory;

    protected $fillable = ['name','start_date','end_date','start_time','end_time','day','container_color','max_student','type','price','code','room_id','course_id'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'classitem_students')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_classitems')->withTimestamps()   ;
    }

    public function users_classitems()
    {
        return $this->hasMany(UserClassitem::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
