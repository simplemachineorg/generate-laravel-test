<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;

use function Pest\Laravel\artisan;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can place a file by path', function () {

    $path = __DIR__.'/Samples/CountTokens.php';
    //
    //    Http::fake([
    //        '*' => Http::response(
    //            body: fixture('good'), // the response data
    //        ),
    //    ]);

    $test_path = base_path(config('generate-laravel-test.draft_test_file_path', 'tests/_draft/CountTokensTest.php'));

    mock(Filesystem::class, fn (MockInterface $mock) => $mock
        ->shouldReceive('makeDirectory')
        ->andReturnTrue()
        ->shouldReceive('put')
        ->once()
        ->with($test_path)
        ->andReturnTrue()
    );

    artisan("generate:test {$path}")
        ->assertOk()
        ->expectsOutput('We saved your draft test');

});
