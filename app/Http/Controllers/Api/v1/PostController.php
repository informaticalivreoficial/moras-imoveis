<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostGb;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $data['category'] = 26;
        $data['cat_pai'] = 3;

        // 🧠 fallback SEO
        $data['title'] = $data['title'];
        $data['content'] = $data['content'] 
            ?? Str::limit(strip_tags($data['content']), 160);

        // 💾 cria post
        $post = Post::create($data);

        $image = $this->generateThumb($post);

        return response()->json([
            'success' => true,
            'post_id' => $post->id,
            'url' => url('/blog/artigo/' . $post->slug),
            'image' => $image
        ]);
    }

    private function generateThumb(Post $post): ?string
    {
        try {

            $manager = new ImageManager(
                new Driver()
            );

            // 🖼️ imagem base
            $image = $manager->read(
                storage_path('app/public/defaults/post.jpg')
            );

            // 📐 tamanho padrão
            $image->cover(1200, 630);

            // 📝 título
            $title = wordwrap(
                Str::limit($post->title, 90),
                54,
                "\n"
            );

            // ✍️ texto Preto
            $image->text(
                $title,
                52,
                483,
                function ($font) {

                    $font->filename(
                        public_path('fonts/Roboto-Bold.ttf')
                    );

                    $font->size(42);
                    $font->lineHeight(1.6);
                    $font->color('rgba(0,0,0,0.5)');
                    $font->align('left');
                    $font->valign('top');
                }
            );

            // ✍️ texto
            $image->text(
                $title,
                49,
                480,
                function ($font) {

                    $font->filename(
                        public_path('fonts/Roboto-Bold.ttf')
                    );

                    $font->size(42);
                    $font->lineHeight(1.6);
                    $font->color('#ffffff');
                    $font->align('left');
                    $font->valign('top');
                }
            );

            // 📁 pasta
            $dir = 'posts/' . $post->id;

            Storage::makeDirectory($dir);

            // 📄 nome
            $name = Str::slug($post->title) . '.webp';

            $path = $dir . '/' . $name;

            // 💾 salvar
            Storage::put(
                $path,
                (string) $image->toWebp(85)
            );

            // 🗂️ banco
            PostGb::create([
                'post' => $post->id,
                'cover' => true,
                'path' => $path,
            ]);

            return Storage::url($path);

        } catch (\Exception $e) {

            logger()->error('Erro thumb', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }
}
