<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
        if ($request->bearerToken() !== config('app.api_token')) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        // 🔐 validação básica
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|string',
        ]);

        // ⚙️ dados automáticos
        $data['autor'] = 1;
        $data['status'] = 0;
        $data['category'] = 3;
        $data['cat_pai'] = 26;

        // 🧠 fallback SEO
        $data['title'] = $data['title'];
        $data['content'] = $data['content'] 
            ?? Str::limit(strip_tags($data['content']), 160);

        // 💾 cria post
        $post = Post::create($data);

        return response()->json([
            'success' => true,
            'post_id' => $post->id,
            'url' => url('/blog/artigo/' . $post->slug)
        ]);
    }
}
