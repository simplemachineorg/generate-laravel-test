<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Rajentrivedi\TokenizerX\TokenizerX;

class CountTokens
{
    use AsAction;

    /**
     * $model is either gpt-3.5-turbo or gpt-4
     * they calculate the same.
     */
    public function handle(string $string, string $model = 'gpt-3.5-turbo')
    {
        return TokenizerX::count($string, $model);
    }
}
