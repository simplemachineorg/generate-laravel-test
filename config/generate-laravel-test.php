<?php

// config for Simplemachine/GenerateLaravelTest
return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | A Simple Machine API key is required to use this package.
    |
    */
    'api_key' => env('SIMPLEMACHINE_API_KEY'),

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
