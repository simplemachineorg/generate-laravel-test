<?php

namespace Simplemachine\GenerateLaravelTest;

use Simplemachine\GenerateLaravelTest\Commands\GenerateTestCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->name('generate_laravel_test')
            ->hasConfigFile('generate-laravel-test')
            ->hasViews()
            ->hasCommand(GenerateTestCommand::class);
    }
}
