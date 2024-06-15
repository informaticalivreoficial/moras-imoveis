<?php

namespace App\Livewire\Admin;

use App\Models\Property as ModelsProperty;
use Livewire\Component;
use Livewire\WithPagination;

class Property extends Component
{
    use WithPagination;
    public $propertyId, $updateProperty = false, $addProperty = false;
    
    public function render()
    {
        $properties = ModelsProperty::orderBy('created_at', 'DESC')->orderBy('status', 'ASC')->paginate(50);
        return view('admin.properties.livewire.list',[
            'properties' => $properties
        ]);
    }

    public function addProperty()
    {
        return view('admin.properties.create');
    }

    public function delete($id){
        try {
            ModelsProperty::where('id',$id)->delete();
            return $this->redirect('/admin/imoveis',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        try {
            $property = ModelsProperty::findOrFail($id);
            if( !$property) {
                session()->flash('error','Este imóvel não existe!');
            } else {
                $this->title = $post->title;
                $this->description = $post->description;
                $this->postId = $post->id;
                $this->updateProperty = true;
                $this->addProperty = false;
            }
        } catch (\Exception $ex) {
            session()->flash('error','Algo deu errado!!');
        }
    }
}
