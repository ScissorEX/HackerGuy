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
        $content = $post->content;
        $maxwords = 250;
        $sentences = preg_split('/[.!?]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $currentchunk = '';
        $chunksarray = [];
        array_push($chunksarray, $post->title);
        foreach ($sentences as $sentence) {
            if ((str_word_count($currentchunk) + str_word_count($sentence)) > $maxwords) {
                array_push($chunksarray, $currentchunk);
                $currentchunk = trim($sentence).'. ';
            } else {
                $currentchunk .= trim($sentence).'. ';
            }
        }
        if (! empty($currentchunk)) {
            $chunksarray[] = $currentchunk;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('services.cohere.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.cohere.ai/v2/embed', [
                'model' => 'embed-v4.0',
                'texts' => $chunksarray,
                'input_type' => 'search_document',
                'embedding_types' => ['float'],
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to embed post {$this->postId}: ".$e->getMessage());
            throw $e; // This triggers retry
        }
        $embeddings = $response->json('embeddings.float');
        foreach ($embeddings as $index => $embedding) {
            $vector = '['.implode(',', $embedding).']';
            $chunktext = $chunksarray[$index];

            DB::connection('pgsql')->insert('INSERT INTO post_embeddings (post_id, chunk_index, chunk_text, embedding) VALUES (?, ?, ?, ?)', [$this->postId, $index, $chunktext, $vector]);
        }

    }
}
