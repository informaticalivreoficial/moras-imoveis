<div>
    <div class="card">
        <div class="card-header text-right">
            <a href="{{route('imoveis.create')}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
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
            @if(!empty($imoveis) && $imoveis->count() > 0)
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
                        @foreach($imoveis as $imovel)                    
                        <tr style="{{ ($imovel->status == '1' ? '' : 'background: #fffed8 !important;')  }}">                            
                            <td class="text-center">
                                <a href="{{url($imovel->nocover())}}" data-title="{{$imovel->titulo}}" data-toggle="lightbox">
                                    <img alt="{{$imovel->titulo}}" src="{{url($imovel->cover())}}" width="60">
                                </a>
                            </td>
                            <td>{{$imovel->titulo}}</td>
                            <td>{{$imovel->categoria}}</td>
                            <td class="text-center">{{$imovel->countimages()}}</td>
                            <td class="text-center">{{$imovel->views}}</td>
                            @if($imovel->venda == 1 && $imovel->locacao == 0)
                            <td class="text-center text-xs">R$ {{str_replace(',00', '', $imovel->valor_venda)}}</td>
                            @elseif($imovel->venda == 1 && $imovel->locacao == 1)
                            <td class="text-center text-xs">R$ {{str_replace(',00', '', $imovel->valor_venda)}}/R$ {{str_replace(',00', '', $imovel->valor_locacao)}}</td>
                            @else
                            <td class="text-center text-xs">R$ {{str_replace(',00', '', $imovel->valor_locacao)}}</td>
                            @endif
                            <td class="text-center">{{$imovel->referencia}}</td>
                            <td class="acoes">
                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Marcar como Destaque" class="btn btn-xs {{ ($imovel->destaque == true ? 'btn-warning' : 'btn-secondary') }} icon-notext j_destaque" data-action="{{ route('imoveis.destaque', ['id' => $imovel->id]) }}"><i class="fas fa-award"></i></a>
                                <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $imovel->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $imovel->status == true ? 'checked' : ''}}>
                                <button data-toggle="tooltip" data-placement="top" title="Inserir Marca D'agua" type="button" class="btn btn-xs btn-secondary text-white j_marcadagua {{$imovel->id}} @php if($imovel->imagesmarcadagua() >= 1){echo '';}else{echo 'disabled';}  @endphp" id="{{$imovel->id}}" data-id="{{$imovel->id}}"><i class="fas fa-copyright icon{{$imovel->id}}"></i></button>
                                @if (!empty($imovel->slug))
                                    @if($imovel->venda == true && !empty($imovel->valor_venda))
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.buyProperty', ['slug' => $imovel->slug]) }}" title="{{$imovel->titulo}}"><i class="fas fa-search"></i></a>
                                    @elseif($imovel->locacao == true && !empty($imovel->valor_locacao))
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.rentProperty', ['slug' => $imovel->slug]) }}" title="{{$imovel->titulo}}"><i class="fas fa-search"></i></a>
                                    @else
                                        <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="#" title="{{$imovel->titulo}}"><i class="fas fa-search"></i></a>
                                    @endif
                                @endif                            
                                <a data-toggle="tooltip" data-placement="top" title="Editar Imóvel" href="{{route('imoveis.edit',$imovel->id)}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button data-placement="top" title="Remover Imóvel" type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$imovel->id}}" data-toggle="modal" data-target="#modal-default"><i class="fas fa-trash"></i></button>
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
            {{ $imoveis->links() }}
        </div>
        <!-- /.card-body -->
    </div>
</div>