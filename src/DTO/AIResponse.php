<?php

namespace Simplemachine\GenerateLaravelTest\DTO;

class AIResponse
{
    public function __construct(
        public string $response,
        public int $prompt_tokens,
        public int $completion_tokens,
        public int $total_tokens,
        public string $model
    ) {}

    public function json()
    {
        return json_decode($this->response);
    }
}
