@extends('adminlte::page')

@section('title', 'Cadastrar Usuário')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastrar Usuário</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Usuários</a></li>
                <li class="breadcrumb-item active">Cadastrar Usuário</li>
            </ol>
        </div>
    </div>
@stop

@section('content')    
    <div class="row">
        <div class="col-12">
            @if($errors->all())
                @foreach($errors->all() as $error)
                    @message(['color' => 'danger'])
                        {{ $error }}
                    @endmessage
                @endforeach
            @endif 
        </div>            
    </div>
    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf            
        <div class="row">            
            <div class="col-12">
                <div class="card card-teal card-outline card-outline-tabs">

                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Dados Cadastrais</a>
                            </li>                               
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Dados Complementares</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-redes-tab" data-toggle="pill" href="#custom-tabs-four-redes" role="tab" aria-controls="custom-tabs-four-redes" aria-selected="false">Redes Sociais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-permissoes-tab" data-toggle="pill" href="#custom-tabs-four-permissoes" role="tab" aria-controls="custom-tabs-four-permissoes" aria-selected="false">Permissões</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">


                                <div class="row">                                        
                                    <div class="col-12 col-md-6 col-lg-3"> 
                                        <div class="form-group">
                                            <div class="thumb_user_admin">
                                                @php
                                                    if(!empty($user->avatar) && \Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . $user->avatar)){
                                                        $cover = url('storage/'.$user->avatar);
                                                    } else {
                                                        $cover = url(asset('backend/assets/images/image.jpg'));
                                                    }
                                                @endphp
                                                <img id="preview" src="{{$cover}}" alt="{{ old('name') }}" title="{{ old('name') }}"/>
                                                <input id="img-input" type="file" name="avatar">
                                            </div>                                                
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-9"> 
                                        <div class="row mb-2">
                                            <div class="col-12 col-md-6 col-lg-8 mb-2">
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*Nome</b></label>
                                                    <input type="text" class="form-control" placeholder="Nome" name="name" value="{{ old('name') }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*Data de Nascimento</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker-here" data-language='pt-BR' name="birthday" value="{{ old('birthday') }}"/>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>                                                    
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*Genero</b></label>
                                                    <select class="form-control" name="gender">
                                                        <option value="masculino" {{(old('gender') == 'masculino' ? 'selected' : '') }}>Masculino</option>
                                                        <option value="feminino" {{(old('gender') == 'feminino' ? 'selected' : '') }}>Feminino</option>
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*Estado Civil</b></label>
                                                    <select class="form-control" name="civil_status">
                                                        <optgroup label="Cônjuge Obrigatório">
                                                            <option value="casado" {{ (old('civil_status') == 'casado' ? 'selected' : '') }}>Casado</option>
                                                            <option value="separado" {{ (old('civil_status') == 'separado' ? 'selected' : '') }}>Separado</option>
                                                            <option value="solteiro" {{ (old('civil_status') == 'solteiro' ? 'selected' : '') }}>Solteiro</option>
                                                            <option value="divorciado" {{ (old('civil_status') == 'divorciado' ? 'selected' : '') }}>Divorciado</option>
                                                            <option value="viuvo" {{ (old('civil_status') == 'viuvo' ? 'selected' : '') }}>Viúvo(a)</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*CPF</b></label>
                                                    <input type="text" class="form-control cpfmask" placeholder="CPF do Cliente" name="cpf" value="{{ old('cpf') }}"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>RG</b></label>
                                                    <input type="text" class="form-control rgmask" placeholder="RG do Cliente" name="rg" value="{{ old('rg') }}"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>Órgão Expedidor</b></label>
                                                    <input type="text" class="form-control" placeholder="Expedição" name="rg_expedition" value="{{ old('rg_expedition') }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-4 mb-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>Naturalidade</b></label>
                                                    <input type="text" class="form-control" placeholder="Cidade de Nascimento" name="naturalness" value="{{ old('naturalness') }}">
                                                </div>
                                            </div>
                                        </div>                                           
                                    </div>
                                    
                                </div>

                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>
                                                <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco">
                                                    <i class="nav-icon fas fa-plus mr-2"></i> Endereço
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseEndereco" class="panel-collapse collapse show">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-12 col-md-2 col-lg-2"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>CEP:</b></label>
                                                            <input type="text" id="cep" class="form-control mask-zipcode" placeholder="Digite o CEP" name="postcode" value="{{old('postcode')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Estado:</b></label>
                                                            <input type="text" class="form-control" id="uf" name="uf" value="{{old('uf')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Cidade:</b></label>
                                                            <input type="text" class="form-control" id="cidade" name="cidade" value="{{old('cidade')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Bairro:</b></label>
                                                            <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="bairro" value="{{old('bairro')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12 col-md-6 col-lg-5"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Rua/Av:</b></label>
                                                            <input type="text" class="form-control" id="rua" name="rua" value="{{old('rua')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Número:</b></label>
                                                            <input type="text" class="form-control" placeholder="Número do Endereço" name="num" value="{{old('num')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Complemento:</b></label>
                                                            <input type="text" class="form-control" placeholder="Complemento (Opcional)" name="complemento" value="{{old('complemento')}}">
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>
                                                <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseContato">
                                                    <i class="nav-icon fas fa-plus mr-2"></i> Contato
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseContato" class="panel-collapse collapse show">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-12 col-md-6 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Residencial:</b></label>
                                                            <input type="text" class="form-control telefonemask" placeholder="Número do Telefone com DDD" name="telefone" value="{{old('telefone')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>*Celular:</b></label>
                                                            <input type="text" class="form-control celularmask" placeholder="Número do Celular com DDD" name="celular" value="{{old('celular')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>WhatsApp:</b></label>
                                                            <input type="text" class="form-control whatsappmask" placeholder="Número do Celular com DDD" name="whatsapp" value="{{old('whatsapp')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>*E-mail:</b></label>
                                                            <input type="email" class="form-control" placeholder="Melhor e-mail" name="email" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Email Alternativo:</b></label>
                                                            <input type="text" class="form-control" placeholder="Email Alternativo" name="email1" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Telegram:</b></label>
                                                            <input type="text" class="form-control" placeholder="Usuário Telegram" name="telegram" value="{{old('telegram')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (\Illuminate\Support\Facades\Auth::user()->superadmin == 1)
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>
                                                    <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                                        <i class="nav-icon fas fa-plus mr-2"></i> Acesso
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFour" class="panel-collapse collapse show">
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        
                                                        <div class="col-6 col-md-6 col-lg-6"> 
                                                            <div class="form-group">
                                                                <label class="labelforms text-muted"><b>*Senha:</b></label>
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control" id="senha" autocomplete="off" name="password" value=""/>
                                                                    <div class="input-group-append" id="olho">
                                                                        <div class="input-group-text"><i class="fa fa-eye"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div> 
                            </div>
                            
                            <div class="tab-pane fade" id="custom-tabs-four-redes" role="tabpanel" aria-labelledby="custom-tabs-four-redes-tab">
                                <div class="row mb-2 text-muted">
                                    <div class="col-sm-12 text-muted">
                                        <div class="form-group">
                                            <h5><b>Redes Sociais</b></h5>            
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Facebook:</b></label>
                                            <input type="text" class="form-control text-muted" placeholder="Facebook" name="facebook" value="{{old('facebook')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Twitter:</b></label>
                                            <input type="text" class="form-control text-muted" placeholder="Twitter" name="twitter" value="{{old('twitter')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Youtube:</b></label>
                                            <input type="text" class="form-control text-muted" placeholder="Youtube" name="youtube" value="{{old('youtube')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Flickr:</b></label>
                                            <input type="text" class="form-control text-muted" placeholder="Flickr" name="fliccr" value="{{old('fliccr')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Instagram:</b></label>
                                            <input type="text" class="form-control text-muted" placeholder="Instagram" name="instagram" value="{{old('instagram')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Vimeo:</b></label>
                                            <input type="text" class="form-control text-muted" placeholder="Vimeo" name="vimeo" value="{{old('vimeo')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Linkedin:</b></label>
                                            <input type="text" class="form-control text-muted" placeholder="Linkedin" name="linkedin" value="{{old('linkedin')}}">
                                        </div>
                                    </div>                                        
                                </div>
                            </div>                                
                            <div class="tab-pane fade" id="custom-tabs-four-permissoes" role="tabpanel" aria-labelledby="custom-tabs-four-permissoes-tab">
                                <div class="row mb-2 text-muted">
                                    <div class="col-sm-12 bg-gray-light mb-3">                                        
                                        <!-- checkbox -->
                                        <div class="form-group p-3 mb-0">
                                            <span class="mr-3"><b>Acesso ao Sistema:</b></span>  
                                            <div class="form-check d-inline mx-2">
                                                <input id="editor" class="form-check-input" type="checkbox" name="editor" {{ (old('editor') == 'on' || old('editor') == true ? 'checked' : '') }}>
                                                <label for="editor" class="form-check-label">Editor</label>
                                            </div>
                                            <div class="form-check d-inline mx-2">
                                                <input id="admin" class="form-check-input" type="checkbox" name="admin" {{ (old('admin') == 'on' || old('admin') == true ? 'checked' : '') }}>
                                                <label for="admin" class="form-check-label">Administrativo</label>
                                            </div>
                                            <div class="form-check d-inline mx-2">
                                                <input id="client" class="form-check-input" type="checkbox"  name="client" {{ (old('client') == 'on' || old('client') == true ? 'checked' : '') }}>
                                                <label for="client" class="form-check-label">Cliente</label>
                                            </div>
                                            @if(\Illuminate\Support\Facades\Auth::user()->superadmin == 1)
                                            <div class="form-check d-inline mx-2">
                                                <input id="superadmin" class="form-check-input" type="checkbox"  name="superadmin" {{ (old('superadmin') == 'on' || old('superadmin') == true ? 'checked' : '') }}>
                                                <label for="superadmin" class="form-check-label">Super Administrador</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>                                        
                                </div>                                   
                            </div>
                        </div>

                        <div class="row text-right">
                            <div class="col-12 mb-4">
                                <button type="submit" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Cadastrar Agora</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->

                    
                </div>
            </div>
        </div>

            

    </form>


@stop

@section('css')    
    <style>
        /* Foto User Admin */
        .thumb_user_admin{
        border: 1px solid #ddd;
        border-radius: 4px; 
        text-align: center;
        }
        .thumb_user_admin input[type=file]{
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        .thumb_user_admin img{
            width: 100%;            
        }
    </style>
<link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
@stop

@section('js')
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $Cpf = $(".cpfmask");
        $Cpf.mask('000.000.000-00', {reverse: true});
        var $whatsapp = $(".whatsappmask");
        $whatsapp.mask('(99) 99999-9999', {reverse: false});
        var $telefone = $(".telefonemask");
        $telefone.mask('(99) 9999-9999', {reverse: false});
        var $celularmask = $(".celularmask");
        $celularmask.mask('(99) 99999-9999', {reverse: false});
        var $zipcode = $(".mask-zipcode");
        $zipcode.mask('00.000-000', {reverse: true});
        var $money = $(".mask-money");
        $money.mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});
    });
</script>    
    <script>
        
        $(function () {  
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 

            function normalizeSpouse() {
                if (typeof ($('select[name="estado_civil"]')) !== 'undefined') {
                    if ($('select[name="estado_civil"]').val() === 'casado' || $('select[name="estado_civil"]').val() === 'separado') {
                        $('.content_spouse input, .content_spouse select').prop('disabled', false);
                    } else {
                        $('.content_spouse input, .content_spouse select').prop('disabled', true);
                    }
                }
            }
            normalizeSpouse();
            $('select[name="estado_civil"]').change(function () {
                normalizeSpouse();
            });           
                    
            function readImage() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        document.getElementById("preview").src = e.target.result;
                    };       
                    file.readAsDataURL(this.files[0]);
                }
            }
            document.getElementById("img-input").addEventListener("change", readImage, false);
                        
           
                        
            // Visualizar senha no input
            var senha = $('#senha');
            var olho= $("#olho");
            olho.mousedown(function() {
                senha.attr("type", "text");
            });
            olho.mouseup(function() {
                senha.attr("type", "password");
            });
            
        });
    </script>
@stop