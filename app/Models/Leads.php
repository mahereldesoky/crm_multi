<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leads extends Model
{
    use HasFactory;
    protected $table = "leads";

    protected $fillable = [
        'team_id',
        'customer_id',
        'details',
        'status'
    ];


    protected $with = ['team','customer'];
    /**
     * Get the team that owns the Leads
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
