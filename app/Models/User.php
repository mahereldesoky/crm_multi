<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Leads;
use App\Models\Customer;
use App\Models\CentralUser;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Contracts\Syncable;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Listeners\UpdateSyncedResource;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements Syncable 
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles , ResourceSyncing  ;
    protected $table = 'users';
    protected $guard_name = 'web';
    public $timestamps = false;

    public function getGlobalIdentifierKey()
    {
        return $this->getAttribute($this->getGlobalIdentifierKeyName());
    }

    public function getGlobalIdentifierKeyName(): string
    {
        return 'global_id';
    }

    public function getCentralModelName(): string
    {
        return CentralUser::class;
    }
    public function getSyncedAttributeNames(): array
    {
        return [
            'name',
            'password',
            'email',
            'global_id'
        ];
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'email',
        'global_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    // protected $with = ['roles'];
    // public function roles(){
    // return $this->hasMany(Role::class);
    // }


    // public function leads(){
    //     return $this->hasMany(Leads::class);
    // }

    // public function customers(){
    //     return $this->hasMany(Customer::class);
    // }

    // public function orders(){
    //     return $this->hasMany(Order::class);
    // }
}
