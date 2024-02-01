<?php

namespace Simplemachine\GenerateLaravelTest\Commands;

use _PHPStan_11268e5ee\Symfony\Component\Finder\SplFileInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Simplemachine\GenerateLaravelTest\GenerateLaravelTest;
use function Laravel\Prompts\search;

class GenerateTestCommand extends Command {

    public $signature = 'generate:test {path?}';

    public $description = 'Use AI to generate a Pest test.';

    public function handle(): int
    {
        try {
            if (!$token = config('generate-laravel-test.api_key')) {
                throw new \Exception('No Simple Machine API Key Found');
            }

            $path = $this->argument('path') ?? $this->searchForPath();
            $file_string = File::get($path);
            $file = new \SplFileInfo($path);

            $response = Http::withToken($token)
                ->timeout(75)
                ->withoutVerifying() // was causing SSL issue. @TODO remove in prod.
                ->withBody(json_encode(['code' => $file_string]))
                ->acceptJson()
                ->post(GenerateLaravelTest::getEndpoint());

            if ($response->failed()) {
                throw new \Exception("Test failed to generate.");
            }

            $test_file = json_decode($response->body())->test;

            $commented_out_file = str($test_file)
                ->replaceMatches('/^/m', '//') // comment out all code.
                    ->replace("&gt;", ">")
                ->remove('<?php')
                ->prepend("<?php\n\n\n");

            // Place the file in the drafts folder.
            $test_directory = base_path(config('generate-laravel-test.draft_test_file_path', 'tests/_draft'));
            if (!File::isDirectory($test_directory)) File::makeDirectory($test_directory, 0755, true);

            $file_name = str($file->getFilename())
                ->remove('.php')
                ->remove('.blade')
                ->remove('-')
                ->title()
                ->append('Test.php');

            $test_path = $test_directory . '/' . $file_name;
            File::put(
                $test_path,
                $commented_out_file
            );

            $this->comment("Done!");
            $this->comment("We saved your draft test in {$test_path}");
            $this->comment("(note: it's commented out to ensure it doesn't conflict.)");

            return self::SUCCESS;
        } catch(\Exception $e) {
            info($e);
            $this->warn("Something went wrong.");
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

        // If using Livewire, add those in.
        $livewire_path = config('livewire.view_path');
        if($livewire_path && File::isDirectory($livewire_path)) {
            $files = $files->merge(File::allFiles($livewire_path));
        };

        // Only get PHP files.
        $files = $files->filter(fn(\SplFileInfo $file) => $file->getExtension() === 'php');

        /**
         * @var int $file_offset
         * Dynamically search for the file. Returns an offset from the above collection.
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
