<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Banners</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Banners</li>
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
                    <a wire:navigate href="{{route('slides.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>        
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">                
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('mensagem') }}
                        @endmessage
                    @endif
                </div>            
            </div>
            @if($slides->count() > 0)
                <table class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th wire:click="sortBy('title')">Título <i class="expandable-table-caret fas fa-caret-down fa-fw"></i></th>
                            <th>Criado em</th>
                            <th>Link</th>
                            <th class="text-center">Expira</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slides as $slide)                    
                        <tr style="{{ ($slide->status == true ? '' : 'background: #fffed8 !important;')  }}">                            
                            <td></td>
                            <td>{{$slide->title}}</td>
                            <td>{{$slide->created_at}}</td>
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                <label class="switch" wire:model="active">
                                    <input type="checkbox" value="{{$slide->status}}"  wire:change="toggleStatus({{$slide->id}})" wire:loading.attr="disabled" {{$slide->status ? 'checked': ''}}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>                                
                                <a wire:navigate href="{{ route('slides.edit', [ 'slide' => $slide->id ]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-xs btn-danger text-white" wire:click="setDeleteId({{$slide->id}})" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>                
                </table>
            @else
                <div class="row mb-4">
                    <div class="col-12">                                                        
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>                                                        
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer clearfix">  
            {{ $slides->links() }}  
        </div>
    </div>

</div>
