<?php

namespace Simplemachine\GenerateLaravelTest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Simplemachine\GenerateLaravelTest\GenerateLaravelTest
 */
class GenerateLaravelTest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Simplemachine\GenerateLaravelTest\GenerateLaravelTest::class;
    }
}
