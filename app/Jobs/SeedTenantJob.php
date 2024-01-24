<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Tenant;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SeedTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $tenant;
    public function __construct(Tenant $tenant )
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */


    public function handle(): void
    {

        $this->tenant->run(function (){

            $user = User::create([
                'name' => $this->tenant->name,
                'email' => $this->tenant->email,
                'password' => $this->tenant->password,
                'global_id' => $this->tenant->global_id,
            ]);

            $user->assignRole('CEO');
        });
    }
}
// $tenant->run(function (){

//     $user = User::find(1);

//     $user->assignRole('CEO');
    

// });
