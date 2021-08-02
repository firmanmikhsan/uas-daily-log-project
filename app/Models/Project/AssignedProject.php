<?php

namespace App\Models\Project;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AssignedProject extends Pivot
{
    protected $table = "assigned_projects";

    protected $fillable = [
        "user_id", "project_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function project()
    {
        return $this->belongsTo(Project::class, "project_id", "id");
    }
}
