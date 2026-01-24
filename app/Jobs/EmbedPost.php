<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmbedPost implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $tries = 3;

    public $backoff = 60;

    public function __construct(public int $postId) {}

    public function handle()
    {
        $post = Post::findOrFail($this->postId);
        $search = $post->title;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('services.cohere.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.cohere.ai/v2/embed', [
                'model' => 'embed-v4.0',
                'texts' => [$search],
                'input_type' => 'search_document',
                'embedding_types' => ['float'],
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to embed post {$this->postId}: ".$e->getMessage());
            throw $e; // This triggers retry
        }
        $embedding = $response->json('embeddings.float.0');
        $vector = '['.implode(',', $embedding).']';

        DB::connection('pgsql')->insert('INSERT INTO post_embeddings (post_id, embedding) VALUES (?, ?)', [$this->postId, $vector]);
    }
}
