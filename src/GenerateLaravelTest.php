<?php

namespace Simplemachine\GenerateLaravelTest;

class GenerateLaravelTest
{
    public static function getEndpoint(): string
    {
        if (app()->isProduction()) {
            return 'https://simplemachine.org/api/generate-laravel-test';
        } else {
            return 'https://simplemachine.test/api/generate-laravel-test';
        }
    }
}
