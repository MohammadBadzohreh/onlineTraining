<?php
namespace Badzohreh\Common\Providers;

use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        require_once __DIR__ . "./../helpers.php";
    }

}
