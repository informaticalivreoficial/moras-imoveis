@extends('adminlte::page')

@section('title', "Cadastrar Imóvel")

@php
$config = [
    "height" => "300",
    "fontSizes" => ['8', '9', '10', '11', '12', '14', '18'],
    "lang" => 'pt-BR',
    "toolbar" => [
        // [groupName, [list of button]]
        ['style', ['style']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        //['font', ['strikethrough', 'superscript', 'subscript']],        
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video','hr']],
        ['view', ['fullscreen', 'codeview']],
    ],
]
@endphp

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Cadastrar Imóvel</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('properties.index')}}">Imóveis</a></li>
            <li class="breadcrumb-item active">Cadastrar Imóvel</li>
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
        <form action="{{ route('property.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Estrutura</a>
                            </li>                            
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Fotos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-seo-tab" data-toggle="pill" href="#custom-tabs-four-seo" role="tab" aria-controls="custom-tabs-four-seo" aria-selected="false">Seo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-integracao-tab" data-toggle="pill" href="#custom-tabs-four-integracao" role="tab" aria-controls="custom-tabs-four-integracao" aria-selected="false">Integração</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                               <div class="row mb-4">
                                    <div class="col-sm-12 bg-gray-light">                                        
                                        <!-- checkbox -->
                                        <div class="form-group p-3 mb-0">
                                            <span class="mr-3 text-muted"><b>Finalidade:</b></span>  
                                            <div class="form-check d-inline mx-2">
                                                <input id="venda" class="form-check-input" type="checkbox" name="sale" {{ (old('sale') == 'on' || old('sale') == true ? 'checked' : '') }}>
                                                <label for="venda" class="form-check-label">Venda</label>
                                            </div>
                                            <div class="form-check d-inline mx-2">
                                                <input id="locacao" class="form-check-input" type="checkbox"  name="location" {{ (old('location') == 'on' || old('location') == true ? 'checked' : '') }}>
                                                <label for="locacao" class="form-check-label">Locação</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 links-locacao" style="display: none;">
                                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Link Booking.com</b></label>
                                            <input type="text" class="form-control" placeholder="Link Booking.com" name="url_booking" value="{{ old('url_booking') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Link Airbnb</b></label>
                                            <input type="text" class="form-control" placeholder="Link Airbnb" name="url_arbnb" value="{{ old('url_arbnb') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12 col-md-6 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Proprietário</b></label>
                                            <select class="form-control" name="owner">
                                                <option value="">Selecione o proprietário</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ (old('owner') == $user->id ? 'selected' : '') }}>
                                                        {{ $user->name }} ({{ ($user->rg ? $user->rg : '---------') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Categoria</b></label>
                                            <select class="form-control" name="category">
                                                <option value=""> Selecione </option>
                                                <option value="Imóvel Residencial" {{(old('category') == 'Imóvel Residencial' ? 'selected' : '')}}>Imóvel Residencial</option>
                                                <option value="Comercial/Industrial" {{(old('category') == 'Comercial/Industrial' ? 'selected' : '')}}>Comercial/Industrial</option>
                                                <option value="Terreno" {{(old('category') == 'Terreno' ? 'selected' : '')}}>Terreno</option>
                                                <option value="Rural" {{(old('category') == 'Rural' ? 'selected' : '')}}>Rural</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Tipo</b></label>
                                           <select class="form-control" name="type">
                                                <option value=""> Selecione </option>
                                                <option value="Casa" {{(old('type') == 'Casa' ? 'selected' : '')}}>Casa</option>
                                                <option value="Cobertura" {{(old('type') == 'Cobertura' ? 'selected' : '')}}>Cobertura</option>
                                                <option value="Apartamento" {{(old('type') == 'Apartamento' ? 'selected' : '')}}>Apartamento</option>
                                                <option value="Studio" {{(old('type') == 'Studio' ? 'selected' : '')}}>Studio</option>
                                                <option value="Kitnet" {{(old('type') == 'Kitnet' ? 'selected' : '')}}>Kitnet</option>
                                                <option value="Sala Comercial" {{(old('type') == 'Sala Comercial' ? 'selected' : '')}}>Sala Comercial</option>
                                                <option value="Salão de Festa" {{(old('type') == 'Salão de Festa' ? 'selected' : '')}}>Salão de Festa</option>
                                                <option value="Chalé" {{(old('type') == 'Chalé' ? 'selected' : '')}}>Chalé</option>
                                                <option value="Hotel Pousada" {{(old('type') == 'Hotel Pousada' ? 'selected' : '')}}>Hotel/Pousada</option>
                                                <option value="Sítio" {{(old('type') == 'Sítio' ? 'selected' : '')}}>Sítio</option>
                                                <option value="Sobrado" {{(old('type') == 'Sobrado' ? 'selected' : '')}}>Sobrado</option>
                                                <option value="Loja" {{(old('type') == 'Loja' ? 'selected' : '')}}>Loja</option>
                                                <option value="Terreno em Condomínio" {{(old('type') == 'Terreno em Condomínio' ? 'selected' : '')}}>Terreno em Condomínio</option>
                                                <option value="Terreno" {{(old('type') == 'Terreno' ? 'selected' : '')}}>Terreno</option>
                                                <option value="Fazenda" {{(old('type') == 'Fazenda' ? 'selected' : '')}}>Fazenda</option>
                                                <option value="Prédio Edifício Inteiro" {{(old('type') == 'Prédio Edifício Inteiro' ? 'selected' : '')}}>Prédio/Edifício Inteiro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-2"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Referência</b></label>
                                            <input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
                                        </div>
                                    </div>                                    
                                </div>
                                
                                <div id="accordion">
                                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>                          
                                                <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseValores">
                                                    <i class="nav-icon fas fa-plus mr-2"></i> Precificação e Valores
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseValores" class="panel-collapse collapse show">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-12"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Deseja exibir os valores?</b> <small class="text-info">(valores exibidos no layout do cliente)</small></label>
                                                            <div class="form-check">
                                                                <input id="exibivaloresim" class="form-check-input" type="radio" value="1" name="display_values" {{(old('display_values') == '1' ? 'checked' : '')}}>
                                                                <label for="exibivaloressim" class="form-check-label mr-5">Sim</label>
                                                                <input id="exibivaloresnao" class="form-check-input" type="radio" value="0" name="display_values" {{(old('display_values') == '0' ? 'checked' : '')}}>
                                                                <label for="exibivaloresnao" class="form-check-label">Não</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Valor de Venda</b></label>
                                                            <input type="text" class="form-control mask-money valor_venda" name="sale_value" value="{{old('sale_value')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Valor de Locação</b></label>
                                                            <input type="text" class="form-control mask-money valor_locacao" name="rental_value" value="{{old('rental_value')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Valor IPTU</b></label>
                                                            <input type="text" class="form-control mask-money" name="iptu" value="{{old('iptu')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Valor Condomínio</b></label>
                                                            <input type="text" class="form-control mask-money" name="condominium" value="{{old('condominium')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2 links-locacao">
                                                    <div class="col-12 col-md-6 col-lg-3"> 
                                                        <div class="form-group">
                                                           <label class="labelforms text-muted"><b>Período da Locação</b></label>
                                                           <select class="form-control" name="location_period">
                                                                <option value=""> Selecione </option>
                                                                <option value="1" {{(old('location_period') == '1' ? 'selected' : '')}}>Diária</option>
                                                                <option value="2" {{(old('location_period') == '2' ? 'selected' : '')}}>Quinzenal</option>
                                                                <option value="3" {{(old('location_period') == '3' ? 'selected' : '')}}>Mensal</option>
                                                                <option value="4" {{(old('location_period') == '4' ? 'selected' : '')}}>Trimestral</option>
                                                                <option value="5" {{(old('location_period') == '5' ? 'selected' : '')}}>Semestral</option>
                                                                <option value="6" {{(old('location_period') == '6' ? 'selected' : '')}}>Anual</option>
                                                                <option value="7" {{(old('location_period') == '7' ? 'selected' : '')}}>Bianual</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                    <div class="col-12"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Deseja exibir o endereço? <small class="text-info">(opção não exibir retornará somente a cidade e estado)</small></b></label>
                                                            <div class="form-check">
                                                                <input id="exibirenderecosim" class="form-check-input" type="radio" value="1" name="display_address" {{(old('display_address') == '1' ? 'checked' : '')}}>
                                                                <label for="exibirenderecosim" class="form-check-label mr-5">Sim</label>
                                                                <input id="exibirendereconao" class="form-check-input" type="radio" value="0" name="display_address" {{(old('display_address') == '0' ? 'checked' : '' )}}>
                                                                <label for="exibirendereconao" class="form-check-label">Não</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12 col-md-2 col-lg-2"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>CEP:</b></label>
                                                            <input type="text" id="cep" class="form-control mask-zipcode" placeholder="Digite o CEP" name="zipcode" value="{{old('zipcode')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Estado:</b></label>
                                                            <input type="text" class="form-control" id="uf" name="state" value="{{old('state')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Cidade:</b></label>
                                                            <input type="text" class="form-control" id="cidade" name="city" value="{{old('city')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Bairro:</b></label>
                                                            <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="neighborhood" value="{{old('neighborhood')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12 col-md-6 col-lg-5"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Rua/Av:</b></label>
                                                            <input type="text" class="form-control" id="rua" name="street" value="{{old('street')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Número:</b></label>
                                                            <input type="text" class="form-control" placeholder="Número do Endereço" name="number" value="{{old('number')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-3"> 
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Complemento:</b></label>
                                                            <input type="text" class="form-control" placeholder="Complemento (Opcional)" name="complement" value="{{old('complement')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>
                                                <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseCaracteristicas">
                                                    <i class="nav-icon fas fa-plus mr-2"></i> Características

                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseCaracteristicas" class="panel-collapse collapse show">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>*Dormitórios</b></label>
                                                            <input type="text" class="form-control" title="Quantidade de Dormitórios" name="dormitories" value="{{old('dormitories')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Suítes</b></label>
                                                            <input type="text" class="form-control" title="Quantidade de Suítes" name="suites" value="{{old('suites')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Banheiros</b></label>
                                                            <input type="text" class="form-control" title="Quantidade de Banheiros" name="bathrooms" value="{{old('bathrooms')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Salas</b></label>
                                                            <input type="text" class="form-control" title="Quantidade de Salas" name="rooms" value="{{old('rooms')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Garagem</b></label>
                                                            <input type="text" class="form-control" title="Quantidade de Garagem" name="garage" value="{{old('garage')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Garagem Coberta</b></label>
                                                            <input type="text" class="form-control" title="Garagem Coberta" name="covered_garage" value="{{old('covered_garage')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Ano de Construção</b></label>
                                                            <input type="text" class="form-control" title="Ano de Construção" name="construction_year" value="{{ old('construction_year') }}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Área Total</b></label>
                                                            <input type="text" class="form-control" title="Área Total" name="total_area" value="{{old('total_area')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Área Útil</b></label>
                                                            <input type="text" class="form-control" title="Área Útil" name="useful_area" value="{{old('useful_area')}}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Medidas</b></label>
                                                            <select class="form-control" name="measures">
                                                                <option value=""> Selecione </option>
                                                                <option value="m²" {{(old('measures') == 'm²' ? 'selected' : '')}}>m²</option>
                                                                <option value="km²" {{(old('measures') == 'km²' ? 'selected' : '')}}>km²</option>
                                                                <option value="hectare" {{(old('measures') == 'hectare' ? 'selected' : '')}}>hectare</option>
                                                                <option value="alqueire" {{(old('measures') == 'alqueire' ? 'selected' : '')}}>alqueire</option>
                                                            </select>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Latitude</b></label>
                                                            <input type="text" class="form-control" title="Latitude" name="latitude" value="{{ old('latitude') }}">
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-2">   
                                                        <div class="form-group">
                                                            <label class="labelforms text-muted"><b>Longitude</b></label>
                                                            <input type="text" class="form-control" title="Longitude" name="longitude" value="{{ old('longitude') }}">
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12">   
                                                        <label class="labelforms text-muted"><b>Descrição do Imóvel</b></label>
                                                        <x-adminlte-text-editor name="description" v placeholder="Descrição do Imóvel..." :config="$config">{{ old('description') }}</x-adminlte-text-editor>                                                      
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12">   
                                                        <label class="labelforms text-muted"><b>Notas Adicionais</b></label>
                                                        <textarea id="inputDescription" class="form-control" rows="5" name="additional_notes">{{ old('additional_notes') ?? 'Os valores podem ser alterados sem aviso prévio. Informações e metragens sujeitos a confirmações. Crédito / Financiamento dependem de aprovação.'}}</textarea>                                                      
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                <div class="row">
                                    <h4>Estrutura</h4>
                                </div>
                                <div class="row mb-4">                                     
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">                                        
                                        <!-- checkbox -->
                                        <div class="form-group p-3 mb-1">
                                            <div class="form-check mb-2">
                                                <input id="areadelazer" class="form-check-input" type="checkbox" name="areadelazer" {{ (old('areadelazer') == 'on' || old('areadelazer') == true ? 'checked' : '') }}>
                                                <label for="areadelazer" class="form-check-label">Área de Lazer</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="ar_condicionado" class="form-check-input" type="checkbox" name="ar_condicionado" {{ (old('ar_condicionado') == 'on' || old('ar_condicionado') == true ? 'checked' : '' ) }}>
                                                <label for="ar_condicionado" class="form-check-label">Ar Condicionado</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="aquecedor_solar" class="form-check-input" type="checkbox" name="aquecedor_solar" {{ (old('aquecedor_solar') == 'on' || old('aquecedor_solar') == true ? 'checked' : '') }}>
                                                <label for="aquecedor_solar" class="form-check-label">Aquecedor Solar</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="armarionautico" class="form-check-input" type="checkbox" name="armarionautico" {{ (old('armarionautico') == 'on' || old('armarionautico') == true ? 'checked' : '' ) }}>
                                                <label for="armarionautico" class="form-check-label">Armário Náutico</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="balcaoamericano" class="form-check-input" type="checkbox"  name="balcaoamericano" {{ (old('balcaoamericano') == 'on' || old('balcaoamericano') == true ? 'checked' : '' ) }}>
                                                <label for="balcaoamericano" class="form-check-label">Balcão Americano</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="banheira" class="form-check-input" type="checkbox"  name="banheira" {{ (old('banheira') == 'on' || old('banheira') == true ? 'checked' : '' ) }}>
                                                <label for="banheira" class="form-check-label">Banheira</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="banheirosocial" class="form-check-input" type="checkbox"  name="banheirosocial" {{ (old('banheirosocial') == 'on' || old('banheirosocial') == true ? 'checked' : '') }}>
                                                <label for="banheirosocial" class="form-check-label">Banheiro Social</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="bar" class="form-check-input" type="checkbox" name="bar" {{ (old('bar') == 'on' || old('bar') == true ? 'checked' : '' ) }}>
                                                <label for="bar" class="form-check-label">Bar Social</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="biblioteca" class="form-check-input" type="checkbox"  name="biblioteca" {{ (old('biblioteca') == 'on' || old('biblioteca') == true ? 'checked' : '' ) }}>
                                                <label for="biblioteca" class="form-check-label">Biblioteca</label>
                                            </div>  
                                            <div class="form-check mb-2">
                                                <input id="brinquedoteca" class="form-check-input" type="checkbox"  name="brinquedoteca" {{ (old('brinquedoteca') == 'on' || old('brinquedoteca') == true ? 'checked' : '') }}>
                                                <label for="brinquedoteca" class="form-check-label">Brinquedoteca</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="condominiofechado" class="form-check-input" type="checkbox"  name="condominiofechado" {{ (old('condominiofechado') == 'on' || old('condominiofechado') == true ? 'checked' : '') }}>
                                                <label for="condominiofechado" class="form-check-label">Condomínio fechado</label>
                                            </div> 
                                            <div class="form-check mb-2">
                                                <input id="cozinha_planejada" class="form-check-input" type="checkbox"  name="cozinha_planejada" {{ (old('cozinha_planejada') == 'on' || old('cozinha_planejada') == true ? 'checked' : '' ) }}>
                                                <label for="cozinha_planejada" class="form-check-label">Cozinha Planejada</label>
                                            </div>                        
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">                                        
                                        <!-- checkbox -->
                                        <div class="form-group p-3 mb-1"> 
                                            <div class="form-check mb-2">
                                                <input id="cozinha_americana" class="form-check-input" type="checkbox"  name="cozinha_americana" {{ (old('cozinha_americana') == 'on' || old('cozinha_americana') == true ? 'checked' : '' ) }}>
                                                <label for="cozinha_americana" class="form-check-label">Cozinha Americana</label>
                                            </div>                                          
                                            <div class="form-check mb-2">
                                                <input id="churrasqueira" class="form-check-input" type="checkbox"  name="churrasqueira" {{ (old('churrasqueira') == 'on' || old('churrasqueira') == true ? 'checked' : '' ) }}>
                                                <label for="churrasqueira" class="form-check-label">Churrasqueira</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="dispensa" class="form-check-input" type="checkbox"  name="dispensa" {{ (old('dispensa') == 'on' || old('dispensa') == true ? 'checked' : '' ) }}>
                                                <label for="dispensa" class="form-check-label">Despensa</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="edicula" class="form-check-input" type="checkbox" name="edicula" {{ (old('edicula') == 'on' || old('edicula') == true ? 'checked' : '' ) }}>
                                                <label for="edicula" class="form-check-label">Edícula</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="elevador" class="form-check-input" type="checkbox"  name="elevador" {{ (old('elevador') == 'on' || old('elevador') == true ? 'checked' : '' ) }}>
                                                <label for="elevador" class="form-check-label">Elevador</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="escritorio" class="form-check-input" type="checkbox"  name="escritorio" {{ (old('escritorio') == 'on' || old('escritorio') == true ? 'checked' : '' ) }}>
                                                <label for="escritorio" class="form-check-label">Escritório</label>
                                            </div>                                            
                                            <div class="form-check mb-2">
                                                <input id="espaco_fitness" class="form-check-input" type="checkbox"  name="espaco_fitness" {{ (old('espaco_fitness') == 'on' || old('espaco_fitness') == true ? 'checked' : '') }}>
                                                <label for="espaco_fitness" class="form-check-label">Espaço Fitness</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="estacionamento" class="form-check-input" type="checkbox"  name="estacionamento" {{ (old('estacionamento') == 'on' || old('estacionamento') == true ? 'checked' : '' ) }}>
                                                <label for="estacionamento" class="form-check-label">Estacionamento</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="fornodepizza" class="form-check-input" type="checkbox"  name="fornodepizza" {{ (old('fornodepizza') == 'on' || old('fornodepizza') == true ? 'checked' : '' ) }}>
                                                <label for="fornodepizza" class="form-check-label">Forno de Pizza</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="geladeira" class="form-check-input" type="checkbox"  name="geladeira" {{ (old('geladeira') == 'on' || old('geladeira') == true ? 'checked' : '') }}>
                                                <label for="geladeira" class="form-check-label">Geladeira</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="geradoreletrico" class="form-check-input" type="checkbox"  name="geradoreletrico" {{ (old('geradoreletrico') == 'on' || old('geradoreletrico') == true ? 'checked' : '') }}>
                                                <label for="geradoreletrico" class="form-check-label">Gerador elétrico</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="interfone" class="form-check-input" type="checkbox"  name="interfone" {{ (old('interfone') == 'on' || old('interfone') == true ? 'checked' : '') }}>
                                                <label for="interfone" class="form-check-label">Interfone</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">                                        
                                        <!-- checkbox -->
                                        <div class="form-group p-3 mb-1">                                            
                                            <div class="form-check mb-2">
                                                <input id="internet" class="form-check-input" type="checkbox"  name="internet" {{ (old('internet') == 'on' || old('internet') == true ? 'checked' : '') }}>
                                                <label for="internet" class="form-check-label">Internet</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="jardim" class="form-check-input" type="checkbox"  name="jardim" {{ (old('jardim') == 'on' || old('jardim') == true ? 'checked' : '') }}>
                                                <label for="jardim" class="form-check-label">Jardim</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="lareira" class="form-check-input" type="checkbox"  name="lareira" {{ (old('lareira') == 'on' || old('lareira') == true ? 'checked' : '' ) }}>
                                                <label for="lareira" class="form-check-label">Lareira</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="lavabo" class="form-check-input" type="checkbox"  name="lavabo" {{ (old('lavabo') == 'on' || old('lavabo') == true ? 'checked' : '' ) }}>
                                                <label for="lavabo" class="form-check-label">Lavabo</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="lavanderia" class="form-check-input" type="checkbox"  name="lavanderia" {{ (old('lavanderia') == 'on' || old('lavanderia') == true ? 'checked' : '') }}>
                                                <label for="lavanderia" class="form-check-label">Lavanderia</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="mobiliado" class="form-check-input" type="checkbox"  name="mobiliado" {{ (old('mobiliado') == 'on' || old('mobiliado') == true ? 'checked' : '' ) }}>
                                                <label for="mobiliado" class="form-check-label">Mobiliado</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="pertodeescolas" class="form-check-input" type="checkbox" name="pertodeescolas" {{ (old('pertodeescolas') == 'on' || old('pertodeescolas') == true ? 'checked' : '') }}>
                                                <label for="pertodeescolas" class="form-check-label">Perto de Escolas</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="piscina" class="form-check-input" type="checkbox" name="piscina" {{ (old('piscina') == 'on' || old('piscina') == true ? 'checked' : '' ) }}>
                                                <label for="piscina" class="form-check-label">Piscina</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="portaria24hs" class="form-check-input" type="checkbox"  name="portaria24hs" {{ (old('portaria24hs') == 'on' || old('portaria24hs') == true ? 'checked' : '' ) }}>
                                                <label for="portaria24hs" class="form-check-label">Portaria 24 Horas</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="quadrapoliesportiva" class="form-check-input" type="checkbox"  name="quadrapoliesportiva" {{ (old('quadrapoliesportiva') == 'on' || old('quadrapoliesportiva') == true ? 'checked' : '') }}>
                                                <label for="quadrapoliesportiva" class="form-check-label">Quadra poliesportiva</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="quintal" class="form-check-input" type="checkbox"  name="quintal" {{ (old('quintal') == 'on' || old('quintal') == true ? 'checked' : '' ) }}>
                                                <label for="quintal" class="form-check-label">Quintal</label>
                                            </div> 
                                            <div class="form-check mb-2">
                                                <input id="sauna" class="form-check-input" type="checkbox"  name="sauna" {{ (old('sauna') == 'on' || old('sauna') == true ? 'checked' : '' ) }}>
                                                <label for="sauna" class="form-check-label">Sauna</label>
                                            </div>                                           
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">                                        
                                        <!-- checkbox -->
                                        <div class="form-group p-3 mb-1"> 
                                            <div class="form-check mb-2">
                                                <input id="saladetv" class="form-check-input" type="checkbox"  name="saladetv" {{ (old('saladetv') == 'on' || old('saladetv') == true ? 'checked' : '') }}>
                                                <label for="saladetv" class="form-check-label">Sala de TV</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="salaodefestas" class="form-check-input" type="checkbox"  name="salaodefestas" {{ (old('salaodefestas') == 'on' || old('salaodefestas') == true ? 'checked' : '') }}>
                                                <label for="salaodefestas" class="form-check-label">Salão de Festas</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="salaodejogos" class="form-check-input" type="checkbox"  name="salaodejogos" {{ (old('salaodejogos') == 'on' || old('salaodejogos') == true ? 'checked' : '') }}>
                                                <label for="salaodejogos" class="form-check-label">Salão de Jogos</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="zeladoria" class="form-check-input" type="checkbox"  name="zeladoria" {{ (old('zeladoria') == 'on' || old('zeladoria') == true ? 'checked' : '' ) }}>
                                                <label for="zeladoria" class="form-check-label">Serviço de Zeladoria</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="sistemadealarme" class="form-check-input" type="checkbox"  name="sistemadealarme" {{ (old('sistemadealarme') == 'on' || old('sistemadealarme') == true ? 'checked' : '') }}>
                                                <label for="sistemadealarme" class="form-check-label">Sistema de alarme</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="permiteanimais" class="form-check-input" type="checkbox"  name="permiteanimais" {{ (old('permiteanimais') == 'on' || old('permiteanimais') == true ? 'checked' : '') }}>
                                                <label for="permiteanimais" class="form-check-label">Permite animais</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="varandagourmet" class="form-check-input" type="checkbox"  name="varandagourmet" {{ (old('varandagourmet') == 'on' || old('varandagourmet') == true ? 'checked' : '') }}>
                                                <label for="varandagourmet" class="form-check-label">Varanda Gourmet</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="vista_para_mar" class="form-check-input" type="checkbox"  name="vista_para_mar" {{ (old('vista_para_mar') == 'on' || old('vista_para_mar') == true ? 'checked' : '' ) }}>
                                                <label for="vista_para_mar" class="form-check-label">Vista para o Mar</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input id="ventilador_teto" class="form-check-input" type="checkbox"  name="ventilador_teto" {{ (old('ventilador_teto') == 'on' || old('ventilador_teto') == true ? 'checked' : '' ) }}>
                                                <label for="ventilador_teto" class="form-check-label">Ventilador de Teto</label>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                <div class="row mb-4 text-muted">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms"><b>Deseja exibir uma Marca D'agua? </b><small class="text-info">(esta opção permite inserir uma marca em todas as imagens)</small></label>
                                            <div class="form-check">
                                                <input id="exibirmarcadaguasim" class="form-check-input" type="radio" value="1" name="display_marked_water" {{(old('display_marked_water') == '1' ? 'checked' : '')}}>
                                                <label for="exibirmarcadaguasim" class="form-check-label mr-5">Sim</label>
                                                <input id="exibirmarcadaguanao" class="form-check-input" type="radio" value="0" name="display_marked_water" {{(old('display_marked_water') == '0' ? 'checked' : '')}}>
                                                <label for="exibirmarcadaguanao" class="form-check-label">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">   
                                        <div class="form-group">
                                            <label class="labelforms"><b>Legenda da Imagem de Capa</b></label>
                                            <input type="text" class="form-control"  name="caption_img_cover" value="{{ old('caption_img_cover') }}">
                                        </div>                                                    
                                    </div>
                                    <div class="col-sm-12">                                        
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="files[]" multiple>
                                                <label class="custom-file-label" for="exampleInputFile">Escolher Fotos</label>
                                            </div>
                                        </div>                                        
                                        <div class="content_image"></div>
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="tab-pane fade" id="custom-tabs-four-seo" role="tabpanel" aria-labelledby="custom-tabs-four-seo-tab">
                                <div class="row mb-2 text-muted">                                   
                                    <div class="col-12 col-md-6 col-lg-6">   
                                        <div class="form-group">
                                            <label class="labelforms"><b>*Título</b></label>
                                            <input type="text" class="form-control" name="title" value="{{old('title')}}">
                                        </div>                                                    
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">   
                                        <div class="form-group">
                                            <label class="labelforms"><b>Headline</b></label>
                                            <input type="text" class="form-control" name="headline" value="{{old('headline')}}">
                                        </div>                                                    
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms"><b>Experiência</b></label>
                                            <select class="form-control" name="experience">
                                                <option value=""> Selecione </option>
                                                <option value="Cobertura" {{(old('experience') == 'Cobertura' ? 'selected' : '')}}>Cobertura</option>
                                                <option value="Alto Padrão" {{(old('experience') == 'Alto Padrão' ? 'selected' : '')}}>Alto Padrão</option>
                                                <option value="De Frente para o Mar" {{(old('experience') == 'De Frente para o Mar' ? 'selected' : '')}}>De Frente para o Mar</option>
                                                <option value="Condomínio Fechado" {{(old('experience') == 'Condomínio Fechado' ? 'selected' : '')}}>Condomínio Fechado</option>
                                                <option value="Compacto" {{(old('experience') == 'Compacto' ? 'selected' : '')}}>Compacto</option>
                                                <option value="Lojas e Salas" {{(old('experience') == 'Lojas e Salas' ? 'selected' : '')}}>Lojas e Salas</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="col-12 mb-1"> 
                                        <div class="form-group">
                                            <label class="labelforms"><b>MetaTags</b></label>
                                            <input id="tags_1" class="tags" rows="5" name="metatags" value="{{ old('metatags') }}">
                                        </div>
                                    </div>
                                    <div class="col-12"> 
                                        <div class="form-group">
                                            <label class="labelforms"><b>Youtube Vídeo</b></label>
                                            <textarea id="inputDescription" class="form-control" rows="5" name="youtube_video">{{ old('youtube_video') }}</textarea> 
                                        </div>
                                    </div> 
                                    <div class="col-12">   
                                        <label class="labelforms"><b>Mapa do Google</b> <small class="text-info">(Copie o código de incorporação do Google Maps e cole abaixo)</small></label>
                                        <textarea id="inputDescription" class="form-control" rows="5" name="google_map">{{ old('google_map') }}</textarea>                                                      
                                    </div>
                                </div> 
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-integracao" role="tabpanel" aria-labelledby="custom-tabs-four-integracao-tab">
                                <div class="row">
                                    <div class="col-sm-12 text-muted">
                                        <div class="form-group">
                                            <h5><b>Portais de Integração de Imóveis</b></h5>  
                                            <p class="text-info">Selecione os portais o qual você deseja exportar e publicar seus imóveis a partir da sua aplicação.</p>                                          
                                        </div>
                                        <div class="form-group mt-4">
                                            <div class="form-check d-inline mr-3">
                                              <input id="p" class="form-check-input" type="radio" value="0" name="publication_type" {{(old('publication_type') == '0' ? 'checked' : '') }} checked>
                                              <label for="p" class="form-check-label">Padrão</label>
                                            </div>
                                            <div class="form-check d-inline mr-3">
                                              <input id="d" class="form-check-input" type="radio" value="1" name="publication_type" {{(old('publication_type') == '1' ? 'checked' : '') }}>
                                              <label for="d" class="form-check-label">Destaque</label>
                                            </div>
                                            <div class="form-check d-inline">
                                              <input id="sd" class="form-check-input" type="radio" value="2" name="publication_type" {{(old('publication_type') == '2' ? 'checked' : '') }}>
                                              <label for="sd" class="form-check-label">Super destaque</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 text-muted mt-4"> 
                                    @if (!empty($portais) && $portais->count() > 0)
                                        @foreach($portais as $portal)                                       
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">                                       
                                                <div class="form-group pb-3 pr-3">
                                                    <div class="form-check mb-2">
                                                        <input id="zeladoria" class="form-check-input" type="checkbox"  name="portal_{{$portal->id}}" {{(old('portal_'.$portal->id) ? 'checked' : '')}}>
                                                        <label for="zeladoria" class="form-check-label">
                                                            {{$portal->nome}} {{($portal->pago == true && $portal->gratuito == false ? '(Pago)' : 
                                                                                ($portal->gratuito == true && $portal->pago == false ? '(Gratuito)' : 
                                                                                ($portal->gratuito == true && $portal->pago == true ? '(Pago/Gratuito)' : '')))}}
                                                        </label>
                                                    </div>                                               
                                                </div>
                                            </div>
                                        @endforeach                                        
                                    @endif                          
                                </div> 
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="col-12 mb-4">
                                <button type="submit" class="btn btn-lg btn-success"><i class="nav-icon fas fa-check mr-2"></i> Cadastrar Agora</button>
                            </div>
                        </div>  
                                                
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
                                
        
@endsection

@section('css')
<link rel="stylesheet" href="{{url('backend/plugins/jquery-tags-input/jquery.tagsinput.css')}}" />
<style type="text/css">
    div.tagsinput span.tag {
        background: #65CEA7 !important;
        border-color: #65CEA7;
        color: #fff;
        border-radius: 15px;
        -webkit-border-radius: 15px;
        padding: 3px 10px;
    }
    div.tagsinput span.tag a {
        color: #43886e;    
    }
    /* Lista de ImÃ³veis */
    img {
        max-width: 100%;
    }
    .realty_list_item  {    
        border: 1px solid #F3F3F3;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .border-item-imovel{
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #F3F3F3;  
        background-color: #F3F3F3;
    }
   
    .property_image, .content_image {
        width: 100%;
        flex-basis: 100%;
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
    }
    .property_image .property_image_item, .content_image .property_image_item {
        flex-basis: calc(25% - 20px) !important;
        margin-bottom: 20px;
        margin-right: 20px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        position: relative;
    }

    .property_image .property_image_item img, .content_image .property_image_item img {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .property_image .property_image_item .property_image_actions, .content_image .property_image_item .property_image_actions {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .embed {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        max-width: 100%;
    }
</style>
@endsection

@section('js')
<!--tags input-->
<script src="{{url('backend/plugins/jquery-tags-input/jquery.tagsinput.js')}}"></script>
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
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

        $('.valor_locacao').attr('disabled', true);
        $('.valor_venda').attr('disabled', true);

        $("#locacao").on('change',function() {
            if (this.checked) {
                $(".links-locacao").attr("style", "display:flex");
                $('.valor_locacao').attr('disabled', false);
            } else {
                $(".links-locacao").attr("style", "display:none");
                $('.valor_locacao').attr('disabled', true);
            }
        });    
        
        $("#venda").on('change',function() {
            if (this.checked) {
                $('.valor_venda').attr('disabled', false);
            } else {
                $('.valor_venda').attr('disabled', true);
            }
        });
        
        $('input[name="files[]"]').change(function (files) {

            $('.content_image').text('');

            $.each(files.target.files, function (key, value) {
                var reader = new FileReader();
                reader.onload = function (value) {
                    $('.content_image').append(
                        '<div id="list" class="property_image_item">' +
                        '<div class="embed radius" style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;"></div>' +
                        '<div class="property_image_actions">' +
                            '<a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove px-2"><i class="nav-icon fas fa-times"></i> </a>' +
                        '</div>' +
                        '</div>');

                    $('.image-remove1').click(function(){
                        $(this).closest('#list').remove()
                    });
                };
                reader.readAsDataURL(value);
            });
        });
        
        //tag input
        function onAddTag(tag) {
            alert("Adicionar uma Tag: " + tag);
        }
        function onRemoveTag(tag) {
            alert("Remover Tag: " + tag);
        }
        function onChangeTag(input,tag) {
            alert("Changed a tag: " + tag);
        }
        $(function() {
            $('#tags_1').tagsInput({
                width:'auto',
                height:200
            });
        });
    });

    $(document).ready(function() {

        function limpa_formulário_cep() {
            $("#rua").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
        }

        $("#cep").blur(function() {

            var cep = $(this).val().replace(/\D/g, '');

            if (cep != "") {
                
                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {
                    
                    $("#rua").val("Carregando...");
                    $("#bairro").val("Carregando...");
                    $("#cidade").val("Carregando...");
                    $("#uf").val("Carregando...");
                    
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            $("#rua").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                        } else {
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } else {
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulário_cep();
            }
        });
    });
</script>
@endsection