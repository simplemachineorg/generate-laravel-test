<?php

namespace Simplemachine\GenerateLaravelTest\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Simplemachine\GenerateLaravelTest\Actions\RunPrompt;
use function Laravel\Prompts\search;
use function Laravel\Prompts\text;

class GenerateTestCommand extends Command {

    public $signature = 'generate:test {path?}';

    public $description = 'Use AI to generate a Pest test.';

    public string $code;
    public string $test;
    public string $further_testing_note;

    public function handle(): int
    {
        try {

            /**
             * Get the file for the code (usually by searching for it)
             */
            $path = $this->argument('path') ?? $this->searchForPath();
            $this->code = File::get($path);
            $file = new \SplFileInfo($path);

            /**
             * Ask for notes.
             */
            $this->further_testing_note = text("Any specific testing notes? (optional)");

            /**
             * Run AI to generate the test
             */
            $response = (new RunPrompt())->handle(
                'generate_laravel_test::generate-laravel-test-prompt',
                ['code' => $this->code, 'further_testing_note' => $this->further_testing_note],
                'gpt-4-0125-preview'
            );

            $new_test_file = $response->json()->test;

            /**
             * Basic file fixes
             */
            $new_test_file = str($new_test_file)
                ->remove('<?php')
                ->prepend("<?php\n")
                ->replace('&gt;', '>');

            /**
             * Comment out
             */
            if (config('generate-laravel-test.comment_out')) {
                $new_test_file = $new_test_file->replaceMatches('/^/m', '//');
            }


            /**
             * Place the file in the drafts folder.
             */
            $test_directory = base_path(config('generate-laravel-test.draft_test_file_path', 'tests/_draft'));
            if (!File::isDirectory($test_directory)) {
                File::makeDirectory($test_directory, 0755, true);
            }

            $file_name = str($file->getFilename())
                ->remove('.php')
                ->remove('.blade')
                ->remove('-')
                ->title()
                ->append('Test.php');

            $test_path = $test_directory . '/' . $file_name;
            File::put(
                $test_path,
                $new_test_file
            );

            $this->comment("Done! We saved your draft test in {$test_path}");

            if (config('generate-laravel-test.comment_out')) {
                $this->comment("(note: it's commented out to ensure it doesn't break anything.)");
            } else {
                $this->comment("(note: it's not commented out, so things could break.)");
            }

            return self::SUCCESS;

        } catch (\Exception $e) {

            info($e);
            $this->warn('Oops! Something went wrong generating a test. The error message is below.');
            $this->comment($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function searchForPath(): string
    {
        /**
         * @var $files Collection<\SplFileInfo>
         * All files in the app.
         */
        $files = collect(File::allFiles(app_path()));

        /**
         * If using Livewire, add those in.
         */
        $livewire_path = config('livewire.view_path');
        if ($livewire_path && File::isDirectory($livewire_path)) {
            $files = $files->merge(File::allFiles($livewire_path));
        }

        /**
         * Only get PHP files.
         */
        $files = $files->filter(fn(\SplFileInfo $file) => $file->getExtension() === 'php');

        /**
         * @var int $file_offset
         *          Dynamically search for the file. Returns an offset from the above collection.
         */
        $file_offset = (int) search(
            'Search for file',
            fn(string $value) => strlen($value) > 0
                ? $this->filterFiles($files, $value)
                : []
        );

        $file = $files[$file_offset];

        return $file->getPathname();
    }

    /**
     * The map gets only the relative path names for search display.
     * The filter shortens the lsit by the search term $value
     */
    protected function filterFiles(Collection $files, $value): array
    {
        return $files
            ->map(fn(\SplFileInfo $file) => str($file->getPathname())->remove(app_path())->toString()) // just show the relative path
            ->filter(function (string $path) use ($value) {
                return str($path)->contains($value);
            })
            ->all();
    }

}
