<?php

namespace App\Livewire\Dashboard\Slides;

use App\Models\Slide;
use Livewire\Component;
use Livewire\WithFileUploads;

class SlideForm extends Component
{
    use WithFileUploads;

    public ?Slide $slide = null;

    public ?string $title = null;
    public ?string $link = null;
    public ?bool $target = null;
    public ?string $content = null;
    public ?string $category = null;
    public $expired_at = null;
    public ?bool $status = null;

    public $image;

    public bool $isEditing = false; // flag para simplificar no Blade

    public function render()
    {
        return view('livewire.dashboard.slides.slide-form',[
            'titlee' => $this->isEditing ? 'Editar Banner' : 'Cadastrar Banner',
        ]);
    }

    public function mount(Slide $slide)
    {
        $this->slide = $slide->exists ? $slide : new Slide();

        if ($slide->exists) {
            $this->isEditing = true; // Estamos editando
            $this->title = $slide->title;
            $this->link = $slide->link;
            $this->target = $slide->target;
            $this->content = $slide->content;
            $this->target = $slide->exists ? (bool) $slide->target : 0;
            $this->category = $slide->category;
            $this->expired_at = $slide->expired_at;
            $this->status = $slide->status;
        } else {            
            $this->isEditing = false; // Estamos criando
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'image' => $this->slide->exists ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        // upload
        if ($this->image) {
            $path = $this->image->store('slides', 'public');
            $this->slide->image = $path;
        }

        $this->slide->title = $this->title;
        $this->slide->link = $this->link;
        $this->slide->target = $this->target;
        $this->slide->content = $this->content;
        $this->slide->category = $this->category;
        $this->slide->expired_at = $this->expired_at;
        $this->slide->status = $this->status;

        $this->slide->save();

        if ($this->isEditing) {
            $this->dispatch('atualizado');
        } else {
            $this->dispatch('cadastrado');
        }
    }
    
}
