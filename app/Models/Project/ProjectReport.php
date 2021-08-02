<?php

namespace App\Models\Project;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectReport extends Model
{
    use HasFactory;

    protected $table = "daily_reports";

    protected $fillable = [
        "user_id", "project_id", "hours", "description"
    ];

    protected $appends = [
        "report_time"
    ];

    public $timestamps = [
        "created_at", "updated_at"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function project()
    {
        return $this->belongsTo(Project::class, "project_id", "id");
    }

    public function getReportTimeAttribute()
    {
        return Carbon::parse($this->created_at)->timezone('Asia/Jakarta')->format("H:i");
    }
}
