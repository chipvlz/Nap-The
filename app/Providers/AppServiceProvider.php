<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $repositories = [
            'Phone\PhoneRepositoryInterface' => 'Phone\PhoneRepository',
            'PayCard\PayCardRepositoryInterface' => 'PayCard\PayCardRepository',
            'User\UserRepositoryInterface' => 'User\UserRepository',
            'Email\EmailRepositoryInterface' => 'Email\EmailRepository',
        ];
        foreach ($repositories as $key=>$val){
            $this->app->bind("App\\Repositories\\$key", "App\\Repositories\\$val");
        }
    }
}
