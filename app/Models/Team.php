<?php

namespace App\Models;

use App\Models\department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    protected $table = "teams";

    protected $fillable = [
        'department_id',
        'name',
        'role',
    ];



    protected $with = ['department'];
    public function department()
    {
        return $this->belongsTo(department::class);
    }


}
