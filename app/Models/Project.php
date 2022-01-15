<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_id",
        "name",
        "description",
        "manager",
        "status"
    ];


    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function worksheets(){
        return $this->hasMany(Worksheet::class);
    }

}
