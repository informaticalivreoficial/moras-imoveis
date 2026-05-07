<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostFacebookService
{
    public function post(Post $post): bool
    {
        try {
            $response = Http::post(config('services.make.webhook'), [
                'title'   => $post->title,
                'content' => strip_tags($post->content),
                'url'     => url('/blog/artigo/' . $post->slug),
                'image'   => $post->cover(),
            ]);

            if ($response->failed()) {
                Log::error("[PostFacebook] Falha ao postar ID {$post->id}: " . $response->body());
                return false;
            }

            Log::info("[PostFacebook] ✓ Post {$post->id} enviado ao Make.");
            return true;

        } catch (\Exception $e) {
            Log::error("[PostFacebook] Exceção ao postar ID {$post->id}: " . $e->getMessage());
            return false;
        }
    }
}