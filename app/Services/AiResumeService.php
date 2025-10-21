<?php

namespace App\Services;

use App\Models\AiRequest;
use Illuminate\Support\Facades\Http;

class AiResumeService
{
    public function generate(array $profile, string $prompt, string $templateSlug)
    {
        $fullPrompt = "Template: {$templateSlug}\nProfile: " . json_encode($profile) . "\nPrompt: {$prompt}";

        $aiReq = AiRequest::create([
            'user_id' => $profile['user_id'] ?? null,
            'prompt' => $fullPrompt,
        ]);

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a resume generator.'],
                    ['role' => 'user', 'content' => $fullPrompt],
                ],
            ]);

        if ($response->failed()) {
            $aiReq->update(['status' => 'failed']);
            throw new \Exception('AI request failed.');
        }

        $result = $response->json();
        $content = $result['choices'][0]['message']['content'] ?? '';

        $aiReq->update([
            'response' => $content,
            'status' => 'done',
        ]);

        return [
            'html' => $content,
            'meta' => null,
        ];
    }
}

