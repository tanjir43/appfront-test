<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
    */
    public function register(): void
    {
        $this->bindRepositories();
        $this->bindServices();
    }

    /**
     * Bootstrap any application services.
    */
    public function boot(): void
    {
        //
    }

    private function bindRepositories(): void
    {
        $repositoriesPath = app_path('Repositories/Eloquent');
        $interfacesPath = app_path('Contracts/Repositories');

        if (!File::isDirectory($repositoriesPath) || !File::isDirectory($interfacesPath)) {
            return;
        }

        $repositoryFiles = File::files($repositoriesPath);

        foreach ($repositoryFiles as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $interfaceName = $filename.'Interface';
            $interfacePath = $interfacesPath.DIRECTORY_SEPARATOR.$interfaceName.'.php';

            if (File::exists($interfacePath)) {
                $interface = 'App\Contracts\Repositories\\'.$interfaceName;
                $repository = 'App\Repositories\Eloquent\\'.$filename;
                $this->app->bind($interface, $repository);
            }
        }
    }


    private function bindServices(): void
    {
        $servicesPath = app_path('Services');
        $interfacesPath = app_path('Contracts/Services');

        if (!File::isDirectory($servicesPath) || !File::isDirectory($interfacesPath)) {
            return;
        }

        $serviceFiles = File::files($servicesPath);

        foreach ($serviceFiles as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $interfaceName = $filename.'Interface';
            $interfacePath = $interfacesPath.DIRECTORY_SEPARATOR.$interfaceName.'.php';

            if (File::exists($interfacePath)) {
                $interface = 'App\Contracts\Services\\'.$interfaceName;
                $service = 'App\Services\\'.$filename;
                $this->app->bind($interface, $service);
            }
        }
    }
}
