<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    protected $fillable = ['name', 'owner_id'];

    /**
     * علاقة المالك: المساحة تتبع لمستخدم واحد (الأدمن)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * علاقة الأعضاء: المساحة تضم العديد من المستخدمين (الفريق)
     * نستخدم الجدول الوسيط workspace_user الذي أنشأناه
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'workspace_user')
                    ->withPivot('role', 'job_title')
                    ->withTimestamps();
    }

    /**
     * علاقة المشاريع: المساحة تضم العديد من المشاريع
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
        public function taskCategories()
    {
        
        return $this->hasMany(TaskCategory::class);
    }
}