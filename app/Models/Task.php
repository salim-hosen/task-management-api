<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "project_id",
        "user_id",
        "description",
        "start_date",
        "close_date",
        "is_complete",
        "status"
    ];

    public function worksheets(){
        return $this->hasMany(Worksheet::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
