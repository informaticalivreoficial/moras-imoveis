<div>     
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Manifestos na Conferência</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Manifestos</li>
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
                    <a wire:navigate href="{{route('manifests.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Manifesto</a>
                </div>
            </div>
        </div>        
        <!-- /.card-header -->
        <div class="card-body">            
            @if(!empty($manifests) && $manifests->count() > 0)
                <table class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('trip')">Viagem <i class="expandable-table-caret fas fa-caret-down fa-fw"></i></th>
                            <th>Tipo</th>
                            <th>Cliente</th>
                            <th>Itens</th>
                            <th>Valor Total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($manifests as $manifest)                    
                        <tr>                            
                            <td>{{$manifest->trip}}</td>
                            <td>{{$manifest->type}}</td>
                            @if ($manifest->userObject && $manifest->companyObject == null)
                                <td>{{$manifest->userObject->name}} ({{$manifest->userObject->cpf ?? ''}})</td>
                            @elseif ($manifest->companyObject && $manifest->userObject == null)
                                <td>{{$manifest->companyObject->alias_name}}</td>
                            @else
                                <td>Não informado</td>
                            @endif
                            <td>{{$manifest->items->count()}}</td>                            
                            <td>
                                @if ($manifest->items && $manifest->items->count() > 0)
                                    R$ {{
                                        number_format(
                                            $manifest->items->sum('horti-fruit') + 
                                            $manifest->items->sum('cubage') +
                                            $manifest->items->sum('secure') +
                                            $manifest->items->sum('dry_weight') +
                                            $manifest->items->sum('package') +
                                            $manifest->items->sum('glace') +
                                            $manifest->items->sum('tax'),
                                            2,
                                            ',',
                                            '.'
                                        )
                                    }}
                                @endif
                            </td>
                            <td>
                                {{ $manifest->status->label() }}                            
                            <td>
                                <a wire:navigate href="{{route('manifests.view', [ 'manifest' => $manifest->id ])}}" class="btn btn-xs btn-info text-white" title="Visualizar"><i class="fas fa-search"></i></a>
                                <a wire:navigate href="{{ route('manifests.edit', [ 'manifest' => $manifest->id ]) }}" class="btn btn-xs btn-default" title="Editar"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-xs btn-danger text-white p-0" wire:click="setDeleteId({{$manifest->id}})" title="Excluir" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center;">
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
            {{ $manifests->links() }}  
        </div>
    </div>

</div>


<script>
    
    document.addEventListener('livewire:initialized', () => {
        @this.on('swal', (event) => {
            const data = event
            swal.fire({
                icon:data[0]['icon'],
                title:data[0]['title'],
                text:data[0]['text'],
            })
        })

        @this.on('delete-prompt', (event) => {
            swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Você tem certeza que deseja excluir este Manifesto?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch('goOn-Delete')
                }
            })
        })
    });

</script>