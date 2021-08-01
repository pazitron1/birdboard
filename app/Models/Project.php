<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * Mass assignment rules
     * @var array
     */
    protected $guarded = [];

    /**
     * Project path
     * @return string
     */
    public function path()
    {
        return "projects/$this->id";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
