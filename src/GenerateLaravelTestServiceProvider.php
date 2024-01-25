<?php

namespace Simplemachine\GenerateLaravelTest;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Simplemachine\GenerateLaravelTest\Commands\GenerateLaravelTestCommand;

class GenerateLaravelTestServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('generate-laravel-test')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_generate-laravel-test_table')
            ->hasCommand(GenerateLaravelTestCommand::class);
    }
}
