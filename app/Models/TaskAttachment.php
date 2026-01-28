<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    protected $fillable = ['task_id', 'user_id', 'file_path', 'file_name', 'file_type'];

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
