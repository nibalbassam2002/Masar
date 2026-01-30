<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskNote extends Model
{
    
    protected $fillable = ['task_id', 'user_id', 'content'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    // app/Models/TaskNote.php

public function task()
{
    return $this->belongsTo(Task::class);
}
}