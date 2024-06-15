<div>
    <div class="card">
        <div class="card-header text-right">
            <a wire:navigate href="{{route('imoveis.create')}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
        </div>        
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12"> 
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>
            @if(!empty($properties) && $properties->count() > 0)
                <table class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Capa</th>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th>Fotos</th>
                            <th>Views</th>
                            <th>Valor</th>
                            <th>Ref.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $property)                    
                        <tr style="{{ ($property->status == '1' ? '' : 'background: #fffed8 !important;')  }}">                            
                            <td class="text-center">
                                <a href="{{url($property->cover())}}" data-title="{{$property->title}}" data-toggle="lightbox">
                                    <img alt="{{$property->title}}" src="{{url($property->cover())}}" width="60">
                                </a>
                            </td>
                            <td>{{$property->title}}</td>
                            <td>{{$property->category}}</td>
                            <td class="text-center">{{$property->images()->count()}}</td>
                            <td class="text-center">{{$property->views}}</td>
                            @if($property->sale == 1 && $property->location == 0)
                            <td class="text-center text-xs">R$ {{str_replace(',00', '', $property->sale_value)}}</td>
                            @elseif($property->sale == 1 && $property->location == 1)
                            <td class="text-center text-xs">R$ {{str_replace(',00', '', $property->sale_value)}}/R$ {{str_replace(',00', '', $property->rental_value)}}</td>
                            @else
                            <td class="text-center text-xs">R$ {{str_replace(',00', '', $property->rental_value)}}</td>
                            @endif
                            <td class="text-center">{{$property->reference}}</td>
                            <td class="acoes">
                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Marcar como Destaque" class="btn btn-xs {{ ($property->highlight == true ? 'btn-warning' : 'btn-secondary') }} icon-notext j_destaque" data-action="{{ route('imoveis.destaque', ['id' => $property->id]) }}"><i class="fas fa-award"></i></a>
                                <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $property->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $property->status == true ? 'checked' : ''}}>
                                <button data-toggle="tooltip" data-placement="top" title="Inserir Marca D'agua" type="button" class="btn btn-xs btn-secondary text-white j_marcadagua {{$property->id}} @php if($property->imagesmarkedwater() >= 1){echo '';}else{echo 'disabled';}  @endphp" id="{{$property->id}}" data-id="{{$property->id}}"><i class="fas fa-copyright icon{{$property->id}}"></i></button>
                                @if (!empty($property->slug))
                                    @if($property->sale == true && !empty($property->sale_value))
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.buyProperty', ['slug' => $imovel->slug]) }}" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                    @elseif($property->location == true && !empty($property->rental_value))
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.rentProperty', ['slug' => $imovel->slug]) }}" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                    @else
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="#" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                    @endif
                                @endif                            
                                <a data-toggle="tooltip" data-placement="top" title="Editar Imóvel" href="{{route('imoveis.edit',$property->id)}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                
                                <button data-placement="top" title="Remover Imóvel" type="button" class="btn btn-xs btn-danger text-white" wire:click="delete({{$property->id}})" wire:confirm="Are you sure you want to delete this?"><i class="fas fa-trash"></i></button>
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
        <div class="card-footer paginacao">  
            {{ $properties->links() }}
        </div>
        <!-- /.card-body -->
    </div>
</div>