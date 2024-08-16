<?php

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
    'default_model' => env('GENERATE_TEST_DEFAULT_MODEL', 'gpt-4o-mini'),

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
