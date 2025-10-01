<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    public ?Post $post = null;

    public array $images = [];
    public $savedImages = [];

    public string $currentTab = 'dados';

    public $title, $slug, $content, $status, $views,
           $category, $cat_pai, $highlight, $menu,
           $thumb_caption, $type, $coments, $publish_at;

    public array $tags = [];

    public function render()
    {
        $titlee = $this->post->exists ? 'Editar Post' : 'Cadastrar Post';
        return view('livewire.dashboard.posts.post-form',[
            'titlee' => $titlee,
        ]);
    }

    public function mount(Post $post)
    {
        if ($post->exists) {
            $this->post = $post; 

            // Metatags como array
            $this->tags = is_string($post->tags)
                ? explode(',', $post->tags)
                : [];
        } else {
            $this->post = new Post();
        }
    }
}
