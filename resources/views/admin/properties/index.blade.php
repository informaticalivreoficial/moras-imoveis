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

    <livewire:admin.property /> 



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
                    url: "{{ route('imoveis.marcadagua') }}",
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
                    url: "{{ route('imoveis.delete') }}",
                    data: {
                       'id': imovel_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_imovel').val(data.id);
                            $('#frm').prop('action','{{ route('imoveis.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('imoveis.deleteon') }}');
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
                    url: "{{ route('imoveis.imovelSetStatus') }}",
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