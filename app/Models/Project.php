<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // أضيفي هذا السطر للسماح بتعبئة هذه الحقول
    protected $fillable = ['name', 'workspace_id', 'status', 'progress', 'description'];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}