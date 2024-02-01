<?php

use Simplemachine\GenerateLaravelTest\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function fixture(string $name): array
{
    $file = file_get_contents(
        filename: __DIR__ . "/Fixtures/$name.json",
    );

    if(! $file) {
        throw new InvalidArgumentException(
            message: "Cannot find fixture: [$name] at tests/Fixtures/$name.json",
        );
    }

    return json_decode(
        json: $file,
        associative: true,
    );
}