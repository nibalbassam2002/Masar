<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'workspace_id', 'status', 'progress', 'description'];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
        public function tasks()
    {
        return $this->hasMany(Task::class);
    }
        public function users()
    {
        
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}