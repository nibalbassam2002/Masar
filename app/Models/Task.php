<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
      'project_id',
      'creator_id',
      'assignee_id', 
      'parent_id', 
      'title',
      'description',
      'status', 
      'priority',
      'category',
      'due_date'
];

    public function project() {

        return $this->belongsTo(Project::class); 

        }
    public function assignee() { 

        return $this->belongsTo(User::class, 'assignee_id'); 

        }
    public function subtasks() { 

        return $this->hasMany(Task::class, 'parent_id');
        
        }
        public function notes() {
    return $this->hasMany(TaskNote::class)->latest();
}
    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class)->latest();
    }
}
