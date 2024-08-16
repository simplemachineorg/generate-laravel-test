<?php

namespace Simplemachine\GenerateLaravelTest\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Simplemachine\GenerateLaravelTest\DTO\AIResponse;

class RunPrompt
{
    /**
     * We usually want JSON, but this is just in case we don't.
     */
    public function __construct(public ?bool $json_response = true) {}

    /**
     * By default, we send an entire Blade view, rendered out. It's just
     * easier to write complicated prompts in blade views, than it is to
     * try to manipulate complicated strings of text.
     */
    public function handle(string $view_path, ?array $data = [], ?string $model = null): AIResponse
    {
        // Render the prompt text
        $prompt_text = $this->getPrompt($view_path, $data);

        info($prompt_text);

        // Get the Open AI call
        $response = $this->requestOpenAi($prompt_text, $model);

        info('--------');
        info('--------');
        info($response->json()->test);

        return $response;
    }

    /**
     * USE: RunPrompt::asText('your text');
     *
     * This is an affordance to make it easier to just drop in text for
     * simple prompts that don't need their own blade view.
     */
    public static function asText(string $prompt, ?string $model = null, ?bool $json_response = true): AIResponse
    {
        return (new RunPrompt(json_response: $json_response))->handle('utility.basic-prompt', ['text' => $prompt], $model);
    }

    /**
     * Gets the prompt response back from Open AI.
     * Note: you can pass a conversation, or just a single prompt.
     */
    public function requestOpenAi(Collection|string $prompt, ?string $model = null): AIResponse
    {
        // Check if the request is a string and format into an array, if so.
        if (is_string($prompt)) {
            $prompt = collect([['role' => 'user', 'content' => $prompt]]);
        }

        // Set up the model
        if (! $model) {
            $model = config('generate-laravel-test.default_model');
        }

        // Make sure there's an API Key.
        if (! config('generate-laravel-test.open_ai_api_key')) {
            throw new \Exception('No API Key Found');
        }

        // Set up the response body
        $body = [
            'model' => $model,
            'messages' => $prompt->toArray(),
        ];

        // add JSON, if that's our return value (set in the constructor).
        if ($this->json_response) {
            $body['response_format'] = ['type' => 'json_object'];
        }

        // Give it a while.
        set_time_limit(75);

        // Make the API call.
        $result = Http::withToken(config('generate-laravel-test.open_ai_api_key'))
            ->asJson()
            ->acceptJson()
            ->timeout(75)
            ->withBody(json_encode($body)
            )
            ->post('https://api.openai.com/v1/chat/completions');

        // Failure case
        if ($result->status() != 200) {
            throw new \Exception($result->body());
        }

        $object = json_decode($result->body());

        return new AIResponse(
            response: $object->choices[0]->message->content,
            prompt_tokens: $object->usage->prompt_tokens,
            completion_tokens: $object->usage->completion_tokens,
            total_tokens: $object->usage->total_tokens,
            model: $object->model
        );
    }

    public function getPrompt(string $view_name, ?array $data = []): string
    {
        return view($view_name, $data)->render();
    }
}
