<div>
    @section('title', $titlee)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-pencil-alt mr-2"></i> {{ $isEditing ? 'Editar' : 'Cadastrar' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a wire:navigate href="{{ route('posts.categories.index') }}">Categorias</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $isEditing ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card card-teal card-outline">
        <div class="card-body text-muted">
            <div class="row">
                <div class="col-12">
                @if($errors->all())
                        @foreach($errors->all() as $error)
                            @message(['color' => 'danger'])
                            {{ $error }}
                            @endmessage
                        @endforeach
                    @endif 

                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                        {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>
            <form wire:submit.prevent="save" autocomplete="off">
                <div class="row mb-4">
                    <div class="col-4">
                        <div class="form-group">
                            <label><b>Título da Categoria:</b></label>
                            <input type="text" class="form-control" wire:model.defer="title" placeholder="Título da Categoria">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label><b>*Tipo:</b></label>
                            @if($catPai)
                                <input class="form-control" wire:model.defer="type" value="{{$type}}" disabled>
                            @else
                                <select class="form-control" wire:model.defer="type">
                                    <option value="">Selecione</option>
                                    <option value="artigo">Artigo</option>
                                    <option value="noticia">Notícia</option>
                                    <option value="pagina">Página</option>
                                </select>
                            @endif
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label><b>Exibir no site?</b></label>
                            <select class="form-control" wire:model.defer="status">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check mr-2"></i> Salvar Agora
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
