<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Categorias</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Categorias</li>
                    </ol>
                </div>
            </div>
        </div>    
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-6 my-2">
                    <div class="card-tools">
                        <div style="width: 250px;">
                            <form class="input-group input-group-sm" action="" method="post">
                                <input type="text" wire:model.live="search" class="form-control float-right" placeholder="Pesquisar">               
                                
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a wire:navigate href="{{route('posts.categories.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($categories->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped projects">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th class="text-center">Exibir?</th>
                                <th class="text-center">Criado em</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td><i class="fas fa-angle-right"></i> {{$category->title}}</td>
                                    <td class="text-center">{{$category->status}}</td>
                                    <td class="text-center">{{date('d/m/Y H:i', strtotime($category->created_at))}}</td>
                                    <td class="text-center">{{$category->type}}</td>
                                    <td class="px-4 py-4 flex items-center justify-center gap-2 h-full">
                                        <!-- Editar categoria -->
                                        <a wire:navigate 
                                        href="{{ route('posts.categories.edit', ['category' => $category->id]) }}"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition flex-shrink-0">
                                        <i class="fas fa-pen"></i>
                                        </a>

                                        <!-- Criar subcategoria -->
                                        <a wire:navigate 
                                        href="{{ route('posts.categories.create', ['parent' => $category->id]) }}"
                                        class="btn btn-sm btn-success">
                                        Criar Subcategoria
                                        </a>  
                                        <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition flex-shrink-0" wire:click="setDeleteId({{$category->id}})">
                                            <i class="fas fa-trash"></i>
                                        </button>                                 
                                    </td>
                                </tr>
                                @if ($category->children)
                                    @foreach($category->children as $subcategory)                        
                                    <tr>                            
                                        <td><i class="fas fa-angle-double-right"></i>  {{$subcategory->title}}</td>
                                        <td class="text-center">{{$subcategory->status}}</td>
                                        <td class="text-center">{{$subcategory->created_at}}</td>
                                        <td class="text-center">---------</td>
                                        <td class="px-4 py-4 flex items-center justify-center gap-2 h-full">
                                            <a href="{{ route('posts.categories.edit', [ 'category' => $subcategory->id ]) }}" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition flex-shrink-0"><i class="fas fa-pen"></i></a>
                                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition flex-shrink-0" wire:click="setDeleteId({{$subcategory->id}})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table> 
                </div>               
                <div class="mt-3">
                    {{$categories->links()}}
                </div>         
            @else
                <div class="alert alert-info mb-0">
                    Nenhum registro encontrado!
                </div>
            @endif
        </div>
    </div>
</div>
