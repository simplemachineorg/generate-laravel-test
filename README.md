# Use AI to dynamically create a test for a PHP Class in your application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/simplemachineorg/generate-laravel-test.svg?style=flat-square)](https://packagist.org/packages/simplemachineorg/generate-laravel-test)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/simplemachineorg/generate-laravel-test/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/simplemachineorg/generate-laravel-test/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/simplemachineorg/generate-laravel-test/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/simplemachineorg/generate-laravel-test/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/simplemachineorg/generate-laravel-test.svg?style=flat-square)](https://packagist.org/packages/simplemachineorg/generate-laravel-test)

## ALPHA 
This package is a work in progress and may have breaking changes.

## Overview
It allows you to quickly create Laravel tests using GPT. The test is generated using GPT-4o and saved to your tests folder in a _draft folder.

Every test still requires some adjustment, since GPT doesn't know everything about your app, but it's a helpful starting point. I find I write many more tests when the initial work is done for me, and all I need to do is adjust the particulars.

## Installation
1. Run `composer require simplemachineorg/generate-laravel-test`
2. Set `GENERATE_TEST_OPENAI_API_KEY` in your .env to your OpenAI Key.
3. Optionally, you can publish the config file using `php artisan vendor:publish --tag=":generate_laravel_test-config"`

## Using this package
1. Run `php artisan generate:test` 
2. Search for a PHP file that needs a test.
3. Add custom test notes (optional)
4. AI will generate the test!


## Adding custom notes about the app
You can create a file which renders custom notes about the app in every request, so that the test generator is more intelligent about your specific setup. By default, create a view inside `resources/views/utility/generate-test-custom-notes.blade.php` and write your notes.

You can change the location of the file in the config, if you'd like.

## Publishing Config (optional)
```
php artisan vendor:publish --tag=":generate_laravel_test-config"
```

This is the default config file...
```php
return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | An OpenAI API key is required to use this package.
    |
    */
    'open_ai_api_key' => env('GENERATE_TEST_OPENAI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Custom notes Path (optional)
    |--------------------------------------------------------------------------
    |
    | You can create a blade file with extra notes which will get placed
    | inside each request so the AI knows more about your specific app.
    |
    */
    'custom_notes' => env('GENERATE_TEST_EXTRA_NOTES_PATH', 'utility.generate-test-custom-notes'),

    /*
    |--------------------------------------------------------------------------
    | Comment Out code before adding to the project
    |--------------------------------------------------------------------------
    |
    | If PHP detects code inside the project with a syntax error, it will
    | throw an exception until you fix it. So you can comment out all code
    | to avoid runtime errors.
    |
    */
    'comment_out' => env('GENERATE_TEST_COMMENT_OUT', true),

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | The default OpenAI model used for creating tests.
    |
    */
    'default_model' => env('GENERATE_TEST_DEFAULT_MODEL', 'gpt-4o'),

    /*
    |--------------------------------------------------------------------------
    | TEST RUNNER
    |--------------------------------------------------------------------------
    |
    | Either 'pest' or 'phpunit'
    |
    */
    'runner' => env('GENERATE_TEST_RUNNER', 'pest'),

    /*
    |--------------------------------------------------------------------------
    | PATH TO STORE DRAFT FILES
    |--------------------------------------------------------------------------
    |
    | Where should we put the files once they are processed?
    | Note: the files will not be runnable PHP immediately.
    |
    |
    */
    'draft_test_file_path' => env('GENERATE_TEST_FILE_PATH', 'tests/Feature/_draft'),

];
```