<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $fillable = ['name', 'owner_id'];
    public function projects() {

    return $this->hasMany(Project::class);
}

    public function users()
    {
        
        return $this->belongsToMany(User::class, 'project_user'); 
    }
}
