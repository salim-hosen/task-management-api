<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worksheet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "project_id",
        "task_id",
        "user_id",
        "time",
        "date",
        "note"
    ];

}
