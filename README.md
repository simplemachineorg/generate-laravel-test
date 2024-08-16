# Use AI to dynamically create a test for a PHP Class in your application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/simplemachineorg/generate-laravel-test.svg?style=flat-square)](https://packagist.org/packages/simplemachineorg/generate-laravel-test)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/simplemachineorg/generate-laravel-test/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/simplemachineorg/generate-laravel-test/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/simplemachineorg/generate-laravel-test/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/simplemachineorg/generate-laravel-test/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/simplemachineorg/generate-laravel-test.svg?style=flat-square)](https://packagist.org/packages/simplemachineorg/generate-laravel-test)

## ALPHA 
This package is a work in progress and may have breaking changes.

## Overview
It make it easy to quickly create Laravel tests using GPT. The package sends your code file to GPT along with some prompt instructions and saves a draft test in a _draft folder.

Every generated test needs adjustment since GPT doesn't know everything about the app, but it's a helpful starting point. In practice, it's easier to write more tests when the scaffolding work is automated.

## Installation
Issue this command...
```
composer require simplemachineorg/generate-laravel-test`
```
Then, set `GENERATE_TEST_OPENAI_API_KEY` in your .env to your OpenAI Key. 

Optionally, you can publish the config file using... 
```
php artisan vendor:publish --tag=":generate_laravel_test-config"
```

## Using this package
Issue this command to use AI to generate a test...
```
php artisan generate:test
```

## Adding custom notes about the app
You can create a file which renders custom notes about the app in every request, so that the test generator is more intelligent about your specific setup. By default, create a view inside `resources/views/utility/generate-test-custom-notes.blade.php` and write your notes. You can optionally change the location of the file in the config.

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