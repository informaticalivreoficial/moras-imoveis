@extends('adminlte::page')

@section('title', 'Gerenciar Imóveis')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-home mr-2"></i> Imóveis</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Imóveis</li>
        </ol>
    </div>
</div>
@stop

@section('content')

<div class="card">
    <div class="card-header text-right">
        <a href="{{route('property.create')}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
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
                        @if($property->sale === 1 && $property->location == null)
                            <td class="text-center text-xs">{{($property->sale_value != null ? 'R$ ' . str_replace(',00', '', $property->sale_value) : '-----')}}</td>
                        @elseif($property->sale == 1 && $property->location == 1)
                            <td class="text-center text-xs">
                                {{($property->sale_value != null ? 'R$ ' . str_replace(',00', '', $property->sale_value) : '')}}
                                {{($property->rental_value != null ? '/R$ ' . str_replace(',00', '', $property->rental_value) : '')}}
                            </td>
                        @else
                            <td class="text-center text-xs">{{($property->rental_value != null ? '/R$ ' . str_replace(',00', '', $property->rental_value) : '-----')}}</td>
                        @endif
                        <td class="text-center">{{$property->reference}}</td>
                        <td class="acoes">
                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Marcar como Destaque" class="btn btn-xs {{ ($property->highlight == true ? 'btn-warning' : 'btn-secondary') }} icon-notext j_destaque" data-action="{{ route('property.highlight', ['id' => $property->id]) }}"><i class="fas fa-award"></i></a>
                            <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $property->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $property->status == true ? 'checked' : ''}}>
                            <button data-toggle="tooltip" data-placement="top" title="Inserir Marca D'agua" type="button" class="btn btn-xs btn-secondary text-white j_marcadagua {{$property->id}} @php if($property->imagesmarkedwater() >= 1){echo '';}else{echo 'disabled';}  @endphp" id="{{$property->id}}" data-id="{{$property->id}}"><i class="fas fa-copyright icon{{$property->id}}"></i></button>
                            @if (!empty($property->slug))
                                @if($property->sale == true && !empty($property->sale_value))
                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.buyProperty', ['slug' => $property->slug]) }}" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                @elseif($property->location == true && !empty($property->rental_value))
                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="{{ route('web.rentProperty', ['slug' => $property->slug]) }}" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                @else
                                    <a target="_blank" data-toggle="tooltip" data-placement="top" title="Visualizar Imóvel" class="btn btn-xs btn-info text-white" href="#" title="{{$property->title}}"><i class="fas fa-search"></i></a>
                                @endif
                            @endif                            
                            <a data-toggle="tooltip" data-placement="top" title="Editar Imóvel" href="{{route('property.edit',$property->id)}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                            
                            <button data-placement="top" title="Remover Imóvel" type="button" class="btn btn-xs btn-danger text-white" ><i class="fas fa-trash"></i></button>
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



<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_imovel" name="imovel_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Imóvel!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="j_param_data"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary">Excluir Agora</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop
 

@section('js')
    <script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
    <script>
       $(function () {
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
              event.preventDefault();
              $(this).ekkoLightbox({
                alwaysShowClose: true
              });
            });           

            $('.j_destaque').click(function (event) {
                event.preventDefault();
                var button = $(this);
                $.post(button.data('action'), {}, function (response) {
                    if (response.success === true) {
                        $('.acoes').find('a.btn-warning').removeClass('btn-warning');
                        button.addClass('btn-warning');                        
                        toastr.success('Imóvel para destaque selecionado!');
                        $('[data-toggle="tooltip"]').tooltip("hide");
                    }
                    if(response.success === false){
                        button.addClass('btn-secondary');
                        toastr.error(data.error);
                    }
                }, 'json');
            });

            // FUNÇÃO MARCA DAGUA
            $('.j_marcadagua').click(function(){
                var imovel_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('property.watermark') }}",
                    data: {
                       'id': imovel_id
                    },
                    beforeSend:function(){
                        $('[data-toggle="tooltip"]').tooltip("hide");
                        $('.icon'+imovel_id).hide();
                        $('.'+imovel_id).html("<img style='width:16px;' src='{{url(asset('backend/assets/images/loading.gif'))}}' />");
                    },
                    complete: function(){
                        $('[data-toggle="tooltip"]').tooltip("hide"); 
                        $('.'+imovel_id).html("<i class='fas fa-copyright icon'></i>");                                  
                    },
                    success:function(data){
                        if(data.success){
                            toastr.success(data.success);
                            $('#'+imovel_id).prop('disabled', true);
                            $('[data-toggle="tooltip"]').tooltip("hide");
                        }else{
                            toastr.error(data.error);
                        }                        
                    }
                });
            });
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var imovel_id = $(this).data('id');                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('property.delete') }}",
                    data: {
                       'id': imovel_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_imovel').val(data.id);
                            $('#frm').prop('action','{{ route('property.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('property.deleteon') }}');
                        }
                    }
                });
            });

            $('#toggle-two').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
            
            $('.toggle-class').on('change', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var imovel_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('property.setStatus') }}",
                    data: {
                        'status': status,
                        'id': imovel_id
                    },
                    success:function(data) {
                        
                    }
                });
            });
        });
    </script>
@endsection