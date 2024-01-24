<?php

namespace App\Models;

use App\Models\CentralUser;
use Stancl\Tenancy\Database\Models\TenantPivot;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(CentralUser::class, 'tenant_users', 'tenant_id', 'global_user_id', 'id', 'global_id')
            ->using(TenantPivot::class);
    }

    public static function getCustomColumns() : array  {
        return [
            'id',
            'name',
            'email',
            'password',
            'subdomain',
            'global_id'
        ];
    }

    

   public function setPasswordAttribute($value)  {
    return $this->attributes['password'] = bcrypt($value);
   }
}



