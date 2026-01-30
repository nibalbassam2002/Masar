<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $fillable = [
        'name', 
        'workspace_id', 
        'color',
         'creator_id'
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
