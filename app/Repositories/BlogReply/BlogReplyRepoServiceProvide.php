<?php

namespace App\Repositories\BlogReply;


use Illuminate\Support\ServiceProvider;


class BlogReplyRepoServiceProvide extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\BlogReply\BlogReplyInterface', 'App\Repositories\BlogReply\BlogReplyRepository');
    }
}