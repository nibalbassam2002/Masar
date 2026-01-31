<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
         'role', 
        'job_title'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_user')
                    ->withPivot('role', 'job_title')
                    ->withTimestamps();
    }
    public function currentWorkspace()
{
    return $this->workspaces()->first() 
           ?? Workspace::where('owner_id', $this->id)->first();
}


    public function roleInWorkspace($workspaceId)
    {
        $pivot = $this->workspaces()->where('workspace_id', $workspaceId)->first();
        
        return $pivot ? $pivot->pivot->role : 'Member';
    }
        public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
                    ->withTimestamps();
    }


    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }
    
public function isSuperAdmin()
{
    return $this->is_super_admin === 1 || $this->is_super_admin === true;
}
}
