<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosistion extends Model
{
    use HasFactory;

    /**
     * * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_posistions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(Profile::class, "job_position_id", "id");
    }
}
