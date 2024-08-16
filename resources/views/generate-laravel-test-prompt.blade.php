@props(['code', 'test' => null, 'further_testing_note' => null])

@if($test)
    Below is the code of a Laravel PHP file, and a draft of a {{ config('generate-laravel-test.runner') }} test submitted by a user. They included a specific change they would like to make.
@else
    Below is the code of a Laravel PHP file submitted by a user. We need a Laravel {{ config('generate-laravel-test.runner') }} test created.
@endif

# JSON RESPONSE FORMAT:
{
'notes': 'INSERT_NOTES_HERE',
'test': '',
}

# STEPS:
(1) Before writing the test, please take a few sentences to describe how you plan to think about this problem in the notes section.
(2) Then write a draft {{ config('generate-laravel-test.runner') }} PHP test file like a senior Laravel developer would and add it to the `test` key.

# RULES:
- Only include working {{ config('generate-laravel-test.runner') }} tests.
- User-created input is enclosed in three backticks.
- don't include backticks in your test response, just the PHP test code.

# CODE:
```
{{ $code }}
```

@if ($test)
    # DRAFT TEST:
    (the user submitted this as a starting point for the test. Please modify it based on their request below.)
    ```
    {{ $test }}
    ```
@endif

@php
$custom_notes_path = config('generate-laravel-test.custom_notes');
@endphp

@if(view()->exists($custom_notes_path))
        # NOTES ABOUT THE APP STRUCTURE
        ```
        {{ view($custom_notes_path)->render() }}
        ```
@endif

@if ($further_testing_note)
    # SPECIFIC TEST NOTES:
    ```
    {{ $further_testing_note }}
    ```
@endif