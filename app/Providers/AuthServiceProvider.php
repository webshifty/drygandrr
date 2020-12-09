<?php

namespace App\Providers;

use App\Models\QAndA;
use App\Models\Questions;
use App\Models\User;
use App\Policies\QuestionPolicy;
use App\Policies\RequestPolicy;
use App\Policies\WorkerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Questions::class => QuestionPolicy::class,
        QAndA::class => RequestPolicy::class,
        User::class => WorkerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
