<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    protected $fillable = [
        'user_id', 'phone_number', 'address', 'avatar', "job_position_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function position()
    {
        return $this->belongsTo(JobPosistion::class, "job_position_id", "id");
    }

    public function getAvatarAttribute($value)
    {
        return Storage::disk('public')->url($value);
    }
}
