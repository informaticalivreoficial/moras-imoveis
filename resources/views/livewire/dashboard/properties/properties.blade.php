<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Imóveis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Imóveis</li>
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
                    <a wire:navigate href="{{route('properties.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>

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

            @if ($properties->count())
                <div class="row d-flex align-items-stretch">
                    @foreach($properties as $property)  
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                            <div class="card card-widget widget-user" style="{{ ($property->status == true ? '' : 'background: #fffed8 !important;')  }}">
                                <a href="{{url($property->cover())}}" data-title="{{$property->title}}" data-toggle="lightbox">
                                    <div class="rounded-t h-[175px] p-4 text-center text-white" 
                                        style="background: url('{{url($property->cover())}}') center center;background-size: cover;">
                                        <h3 class="widget-user-username text-right">{{$property->title}}</h3>
                                        <h5 class="widget-user-desc text-right">{{$property->category}} - {{$property->type}}</h5>
                                    </div>       
                                </a>         
                                <div class="py-3 px-3">
                                    <div class="row">
                                        <div class="col-12 text-center mb-2">
                                            @if($property->sale && !$property->location)
                                                {{ $property->formatted_sale_value ? 'Venda ' . $property->formatted_sale_value : '-----' }}
                                            @elseif($property->sale && $property->location)
                                                {{ $property->formatted_sale_value ? 'Venda ' . $property->formatted_sale_value : '' }}
                                                {{ $property->formatted_rental_value ? '/ Locação ' . $property->formatted_rental_value : '' }}
                                            @else
                                                {{ $property->formatted_rental_value ? 'Locação ' . $property->formatted_rental_value : '-----' }}
                                            @endif
                                        </div>
                                        <div class="col-12 text-center mb-2">                                            
                                            <label class="switch" wire:model="active">
                                                <input type="checkbox" value="{{$property->status}}"  wire:change="toggleStatus({{$property->id}})" wire:loading.attr="disabled" {{$property->status ? 'checked': ''}}>
                                                <span class="slider round"></span>
                                            </label>
                                            <div x-data="{ open: false }" class="d-inline-block ml-2 relative">
                                                <button 
                                                    wire:click="toggleHighlight({{ $property->id }})"
                                                    @mouseenter="open = true" 
                                                    @mouseleave="open = false"
                                                    class="btn btn-xs {{ $property->highlight ? 'btn-warning' : 'btn-secondary' }} icon-notext"
                                                >
                                                    <i class="fas fa-award"></i>
                                                </button>

                                                <div 
                                                    x-show="open" 
                                                    class="absolute bottom-full mb-2 px-2 py-1 text-xs text-white bg-gray-700 rounded shadow"
                                                >
                                                    {{ $property->highlight ? 'Remover destaque' : 'Marcar como destaque' }}
                                                </div>
                                            </div>
                                            <button data-toggle="tooltip" data-placement="top" title="Inserir Marca D'agua" type="button" class="btn btn-xs btn-secondary text-white j_marcadagua {{$property->id}} @php if($property->imagesmarkedwater() >= 1){echo '';}else{echo 'disabled';}  @endphp" id="{{$property->id}}" data-id="{{$property->id}}"><i class="fas fa-copyright icon{{$property->id}}"></i></button>
                                            @if ($property->slug)
                                                @if($property->sale == true && !empty($property->sale_value))
                                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.buyProperty', ['slug' => $property->slug]) }}" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                                @elseif($property->location == true && !empty($property->rental_value))
                                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.rentProperty', ['slug' => $property->slug]) }}" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                                @else
                                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="#" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                                @endif
                                            @endif                            
                                            <a wire:navigate title="Editar Imóvel" href="{{ route('property.edit', [ 'property' => $property->id ]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                            <button type="button" class="btn btn-xs btn-danger text-white p-0" wire:click="setDeleteId({{$property->id}})" title="Excluir" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{$property->reference}}</h5>
                                                <span>Referência</span>
                                            </div>                    
                                        </div>
                                        
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{$property->views}}</h5>
                                                <span>Views</span>
                                            </div>                    
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header">{{$property->images()->count()}}</h5>
                                                <span>Imagens</span>
                                            </div>                    
                                        </div>
                                    
                                    </div>                        
                                </div>
                            </div>
                        </div>
                    @endforeach            
                </div>
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
    </div>
</div>
