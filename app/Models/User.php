<?php

namespace App\Models;

use App\Models\Project\AssignedProject;
use App\Models\Project\Project;
use App\Models\Project\ProjectReport;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jobPosition()
    {
        return $this->hasOneThrough(JobPosistion::class, Profile::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, "user_id", "id");
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'assigned_projects', "user_id", "project_id")->withTimestamps();
    }

    public function reports()
    {
        return $this->hasMany(ProjectReport::class, "user_id", "id");
    }
}
