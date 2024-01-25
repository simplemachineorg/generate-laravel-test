<?php

namespace Simplemachine\GenerateLaravelTest\Commands;

use Illuminate\Console\Command;

class GenerateLaravelTestCommand extends Command
{
    public $signature = 'generate-laravel-test';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
