<?php

namespace App\Providers;

use App\Repositories\TeamRepository;
use App\Repositories\LeadsRepository;
use App\Repositories\OrderRepository;
use App\Repositories\AccountRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CustomerRepository;
use App\Repositories\DepartmentRepository;
use App\Interfaces\TeamRepositoryInterface;
use App\Interfaces\LeadsRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\AccountRepositoryInterface;
use App\Interfaces\CustomerRepositryInterface;
use App\Interfaces\DepartmentRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LeadsRepositoryInterface::class,LeadsRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(CustomerRepositryInterface::class, CustomerRepository::class);
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
