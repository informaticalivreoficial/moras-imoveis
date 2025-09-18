<div>     
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Viagens</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Viagens</li>
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
                    <a href="{{route('trips.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Viagem</a>
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
            @if(!empty($trips) && $trips->count() > 0)
                <table class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th  wire:click="sortBy('name')">Viagem <i class="expandable-table-caret fas fa-caret-down fa-fw"></i></th>
                            <th>Início</th>
                            <th>Término</th>
                            <th>Navio</th>
                            <th>Manifestos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)                    
                        <tr>                            
                            <td>{{$trip->name}}</td>
                            <td>{{$trip->start}}</td>
                            <td>{{$trip->stop}}</td>
                            <td>{{$trip->ship}}</td>                            
                            <td>{{$trip->manifests->count()}}</td>                            
                            <td>
                                <button type="button" class="btn btn-xs btn-info text-white" wire:click="show({{ $trip->id }})"><i class="fas fa-search"></i></button>
                                <a wire:navigate href="{{ route('trips.edit', [ 'trip' => $trip->id ]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-xs btn-danger text-white" wire:click="setDeleteId({{$trip->id}})">
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
            {{ $trips->links() }}  
        </div>
    </div>
    @if($showModal && $selectedTrip)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white w-full max-w-md mx-4 p-6 rounded-lg shadow-lg relative">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Detalhes</h2>

                @if($selectedTrip)
                    <div class="space-y-2">
                        <p><strong>ID:</strong> {{ $selectedTrip->id }}</p>
                        <p><strong>Início da viagem:</strong> {{ $selectedTrip->start }}</p>
                        <p><strong>Fim da viagem:</strong> {{ $selectedTrip->stop ?? '—' }}</p>
                        <p><strong>Embarcação:</strong> {{ $selectedTrip->ship }}</p>
                        <p><strong>Informações:</strong> {{ $selectedTrip->information ?? '—' }}</p>
                    </div>
                @endif

                <div class="mt-6 text-right">
                    <button wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif    

</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        Livewire.on('swal', (data) => {
            Swal.fire({
                icon: data[0].icon,
                title: data[0].title,
                text: data[0].text,
            });
        });

        Livewire.on('delete-prompt', () => {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Você tem certeza que deseja excluir esta Viagem?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('goOn-Delete');
                }
            });
        });
    });
</script>