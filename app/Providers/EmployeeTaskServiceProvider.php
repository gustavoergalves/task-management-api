<?php

namespace App\Providers;

use App\Repositories\Contracts\EmployeeTaskRepositoryInterface;
use App\Repositories\EmployeeTaskRepository;
use Illuminate\Support\ServiceProvider;

class EmployeeTaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeTaskRepositoryInterface::class, EmployeeTaskRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
