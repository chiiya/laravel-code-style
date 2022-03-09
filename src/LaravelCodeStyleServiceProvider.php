<?php

namespace Chiiya\LaravelCodeStyle;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelCodeStyleServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-code-style');
    }

    public function bootingPackage(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->package->basePath('/../stubs/ecs.php.stub') => base_path('ecs.php'),
                $this->package->basePath('/../stubs/grumphp.yml.stub') => base_path('grumphp.yml'),
                $this->package->basePath('/../stubs/phpstan.neon.stub') => base_path('phpstan.neon'),
                $this->package->basePath('/../stubs/rector.php.stub') => base_path('rector.php'),
                $this->package->basePath('/../stubs/tlint.json.stub') => base_path('tlint.json'),
                $this->package->basePath('/../stubs/.php-cs-fixer.dist.php.stub') => base_path(
                    '.php-cs-fixer.dist.php',
                ),
            ], "{$this->package->shortName()}-config");
        }
    }
}
