# Use AI to dynamically create a test for a PHP Class in your application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/simplemachineorg/generate-laravel-test.svg?style=flat-square)](https://packagist.org/packages/simplemachineorg/generate-laravel-test)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/simplemachineorg/generate-laravel-test/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/simplemachineorg/generate-laravel-test/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/simplemachineorg/generate-laravel-test/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/simplemachineorg/generate-laravel-test/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/simplemachineorg/generate-laravel-test.svg?style=flat-square)](https://packagist.org/packages/simplemachineorg/generate-laravel-test)

## Package

This package is a work in progress. It allows you to connect to https://simplemachine.org/tools/generate-laravel-test through the command line.

You can type `php artisan generate:test` and get a list of files to generate.

The test is generated using GPT-4, and saved to your tests folder in a _draft folder. But all code is commented out, so you can choose to uncomment what you want.

Every test requires some adjustment, since ChatGPT doesn't know everything about your app. But I find it's often a helpful starting point for "what to test" and the basic contours of a test plan.

## Using this package

To use this package, you'll need a Simple Machine API key, which you can get at https://simplemachine.org/profile.
