<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\CatPost;
use Livewire\Component;

class CatPostForm extends Component
{
    public ?int $parent = null;
    public ?CatPost $catPai = null;

    public $title;
    public $status = 1;
    public $type;
    public $id_pai;

    public bool $isEditing = false;

    public function mount($parent = null)
    {
        $this->parent = $parent;

        if ($this->parent) {
            $this->catPai = CatPost::find($this->parent);
            $this->id_pai = $this->catPai->id;
            $this->type = $this->catPai->type; // força tipo da subcategoria igual ao pai
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|boolean',
            'id_pai' => 'nullable|exists:cat_posts,id',
        ]);

        // Força tipo igual ao pai novamente por segurança
        if ($this->catPai) {
            $this->type = $this->catPai->type;
        }

        CatPost::create([
            'title' => $this->title,
            'status' => $this->status,
            'type' => $this->type,
            'id_pai' => $this->id_pai,
        ]);

        session()->flash('message', 'Categoria salva com sucesso!');
        return redirect()->route('posts.categories.index');
    }

    public function render()
    {
        return view('livewire.dashboard.posts.cat-post-form',[
            'titlee' => $this->isEditing ? 'Editar Categoria' : 'Cadastrar Categoria',
        ]);
    }
}
