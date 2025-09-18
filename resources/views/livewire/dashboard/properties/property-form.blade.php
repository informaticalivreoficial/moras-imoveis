<div>
    @section('title', $titlee)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-file-alt mr-2"></i> {{ $property ? 'Editar Imóvel' : 'Cadastrar Imóvel' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a wire:navigate href="{{route('properties.index')}}">Imóveis</a></li>
                        <li class="breadcrumb-item active">{{ $property ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{
        tab: @entangle('currentTab'),
            init() {
                if (!this.tab) this.tab = 'dados';
            }
        }" class="w-full bg-white">
        <!-- Abas -->
        <div class="flex space-x-2 border-b border-green-300">
            <button type="button"
                    class="px-4 py-4 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'dados' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'dados'">
                📝 Dados
            </button>
            <button type="button"
                    class="px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'estrutura' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'estrutura'">
                🏗️ Estrutura
            </button>
            <button type="button"
                    class="px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'imagens' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'imagens'">
                📷 Imagens
            </button>
            <button type="button"
                    class="px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'seo' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'seo'">
                🔍 Seo
            </button>
        </div>

        <form wire:submit.prevent="save" autocomplete="off">
            <!-- Conteúdo da aba Dados -->
            <div x-show="tab === 'dados'" x-transition>
                <div class="bg-white">
                    <div x-data="{ option: @entangle('option') }" class="card-body text-muted">
                        <div class="row mt-2 mb-3">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2"> 
                                <label class="labelforms"><b>Finalidade:</b></label>
                                <div class="flex gap-3">
                                    @foreach($types as $option)
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="radio" x-model="option" wire:model="option" value="{{ $option }}" class="form-radio text-blue-600">
                                            <span class="ml-2"> {{ $option }} </span>
                                        </label>
                                    @endforeach
                                </div> 
                            </div>
                            
                                                       
                        </div>
                        <div class="row mt-2" x-show="option === 'locacao'">                           
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="labelforms"><b>Link Booking.com</b></label>
                                    <input type="text" class="form-control" placeholder="Link Booking.com" name="url_booking" value="{{ old('url_booking') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="labelforms"><b>Link Airbnb</b></label>
                                    <input type="text" class="form-control" placeholder="Link Airbnb" name="url_arbnb" value="{{ old('url_arbnb') }}">
                                </div>
                            </div>                    
                        </div>
                        <div class="row">                           
                            <div class="col-12 col-md-6 col-lg-5">   
                                <div class="form-group">
                                    <label class="labelforms"><b>*Título</b></label>
                                    <input type="text" class="form-control" wire:model="title">
                                </div>                                                    
                            </div>   
                            <div class="col-12 col-md-3 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Referência</b></label>
                                    <input type="text" class="form-control" id="reference" wire:model="reference">
                                </div>
                            </div> 
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="form-group" x-data="{ value: @entangle('expired_at').defer }" x-init="initFlatpickr()" x-ref="datepicker">
                                    <label class="labelforms"><b>Data de Expiração</b></label>
                                    <input type="text" class="form-control @error('expired_at') is-invalid @enderror" wire:model="expired_at" id="datepicker" />
                                    @error('expired_at')
                                        <span class="error erro-feedback">{{ $message }}</span>
                                    @enderror                                                                                                                                      
                                </div>
                            </div> 
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Categoria</b></label>
                                    <select class="form-control" name="categoria">
                                        <option value=""> Selecione </option>
                                        <option value="Imóvel Residencial" {{(old('categoria') == 'Imóvel Residencial' ? 'selected' : '')}}>Imóvel Residencial</option>
                                        <option value="Comercial/Industrial" {{(old('categoria') == 'Comercial/Industrial' ? 'selected' : '')}}>Comercial/Industrial</option>
                                        <option value="Terreno" {{(old('categoria') == 'Terreno' ? 'selected' : '')}}>Terreno</option>
                                        <option value="Rural" {{(old('categoria') == 'Rural' ? 'selected' : '')}}>Rural</option>
                                    </select>
                                </div>
                            </div>               
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Tipo</b></label>
                                    <select class="form-control" name="tipo">
                                        <option value=""> Selecione </option>
                                        <option value="Casa" {{(old('tipo') == 'Casa' ? 'selected' : '')}}>Casa</option>
                                        <option value="Cobertura" {{(old('tipo') == 'Cobertura' ? 'selected' : '')}}>Cobertura</option>
                                        <option value="Apartamento" {{(old('tipo') == 'Apartamento' ? 'selected' : '')}}>Apartamento</option>
                                        <option value="Studio" {{(old('tipo') == 'Studio' ? 'selected' : '')}}>Studio</option>
                                        <option value="Kitnet" {{(old('tipo') == 'Kitnet' ? 'selected' : '')}}>Kitnet</option>
                                        <option value="Sala Comercial" {{(old('tipo') == 'Sala Comercial' ? 'selected' : '')}}>Sala Comercial</option>
                                        <option value="Salão de Festa" {{(old('tipo') == 'Salão de Festa' ? 'selected' : '')}}>Salão de Festa</option>
                                        <option value="Chalé" {{(old('tipo') == 'Chalé' ? 'selected' : '')}}>Chalé</option>
                                        <option value="Hotel Pousada" {{(old('tipo') == 'Hotel Pousada' ? 'selected' : '')}}>Hotel/Pousada</option>
                                        <option value="Sítio" {{(old('tipo') == 'Sítio' ? 'selected' : '')}}>Sítio</option>
                                        <option value="Sobrado" {{(old('tipo') == 'Sobrado' ? 'selected' : '')}}>Sobrado</option>
                                        <option value="Loja" {{(old('tipo') == 'Loja' ? 'selected' : '')}}>Loja</option>
                                        <option value="Terreno em Condomínio" {{(old('tipo') == 'Terreno em Condomínio' ? 'selected' : '')}}>Terreno em Condomínio</option>
                                        <option value="Terreno" {{(old('tipo') == 'Terreno' ? 'selected' : '')}}>Terreno</option>
                                        <option value="Fazenda" {{(old('tipo') == 'Fazenda' ? 'selected' : '')}}>Fazenda</option>
                                        <option value="Prédio Edifício Inteiro" {{(old('tipo') == 'Prédio Edifício Inteiro' ? 'selected' : '')}}>Prédio/Edifício Inteiro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 border-gray-300">
                        <div class="row">
                            <div class="col-12"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Deseja exibir os valores?</b> <small class="text-info">(valores exibidos no layout do cliente)</small></label>
                                    <div class="form-check">
                                        <input id="exibivaloresim" class="form-check-input" type="radio" value="1" name="exibivalores" {{(old('exibivalores') == '1' ? 'checked' : '')}}>
                                        <label for="exibivaloressim" class="form-check-label mr-5">Sim</label>
                                        <input id="exibivaloresnao" class="form-check-input" type="radio" value="0" name="exibivalores" {{(old('exibivalores') == '0' ? 'checked' : '')}}>
                                        <label for="exibivaloresnao" class="form-check-label">Não</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Venda</b></label>
                                    <input type="text" class="form-control mask-money valor_venda" name="valor_venda" value="{{old('valor_venda')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Locação</b></label>
                                    <input type="text" class="form-control mask-money valor_locacao" name="valor_locacao" value="{{old('valor_locacao')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>IPTU</b></label>
                                    <input type="text" class="form-control mask-money" name="iptu" value="{{old('iptu')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Condomínio</b></label>
                                    <input type="text" class="form-control mask-money" name="condominio" value="{{old('condominio')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Período da Locação</b></label>
                                    <select class="form-control" name="locacao_periodo">
                                        <option value=""> Selecione </option>
                                        <option value="1" {{(old('locacao_periodo') == '1' ? 'selected' : '')}}>Diária</option>
                                        <option value="2" {{(old('locacao_periodo') == '2' ? 'selected' : '')}}>Quinzenal</option>
                                        <option value="3" {{(old('locacao_periodo') == '3' ? 'selected' : '')}}>Mensal</option>
                                        <option value="4" {{(old('locacao_periodo') == '4' ? 'selected' : '')}}>Trimestral</option>
                                        <option value="5" {{(old('locacao_periodo') == '5' ? 'selected' : '')}}>Semestral</option>
                                        <option value="6" {{(old('locacao_periodo') == '6' ? 'selected' : '')}}>Anual</option>
                                        <option value="7" {{(old('locacao_periodo') == '7' ? 'selected' : '')}}>Bianual</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 border-gray-300">
                        <div class="row mb-2">
                            <div class="col-12 mb-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Deseja exibir o endereço? <small class="text-info">(opção não exibir retornará somente a cidade e estado)</small></b></label>
                                    <div class="form-check">
                                        <input id="exibirenderecosim" class="form-check-input" type="radio" value="1" name="exibirendereco" {{(old('exibirendereco') == '1' ? 'checked' : '')}}>
                                        <label for="exibirenderecosim" class="form-check-label mr-5">Sim</label>
                                        <input id="exibirendereconao" class="form-check-input" type="radio" value="0" name="exibirendereco" {{(old('exibirendereco') == '0' ? 'checked' : '' )}}>
                                        <label for="exibirendereconao" class="form-check-label">Não</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>*CEP:</b></label>
                                    <input type="text" x-mask="99.999-999" class="form-control @error('postcode') is-invalid @enderror" id="postcode" wire:model.lazy="postcode">
                                    @error('postcode')
                                        <span class="error erro-feedback">{{ $message }}</span>
                                    @enderror                                                    
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-4 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>*Estado:</b></label>
                                    <input type="text" class="form-control" id="state" wire:model="state" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>*Cidade:</b></label>
                                    <input type="text" class="form-control" id="city" wire:model="city" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>*Rua:</b></label>
                                    <input type="text" class="form-control" id="street" wire:model="street" readonly>
                                </div>
                            </div>                                            
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-4 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>*Bairro:</b></label>
                                    <input type="text" class="form-control" id="neighborhood" wire:model="neighborhood" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Número:</b></label>
                                    <input type="text" class="form-control" placeholder="Número do Endereço" id="number" wire:model="number">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Complemento:</b></label>
                                    <input type="text" class="form-control" id="complement" wire:model="complement">
                                </div>
                            </div>   
                        </div>
                                                
                    </div>
                </div>
            </div>
            <div x-show="tab === 'estrutura'" x-transition>
                <div class="bg-white">
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
            </div>
            <div x-show="tab === 'imagens'" x-transition>
                <div class="bg-white p-4">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6"> 
                            <div class="form-group text-muted">
                                <label class="labelforms"><b>Deseja exibir uma Marca D'agua? </b><small class="text-info">(esta opção permite inserir uma marca em todas as imagens)</small></label>
                                <div class="form-check">
                                    <input id="exibirmarcadaguasim" class="form-check-input" type="radio" value="1" name="exibirmarcadagua" {{(old('exibirmarcadagua') == '1' ? 'checked' : '')}}>
                                    <label for="exibirmarcadaguasim" class="form-check-label mr-5">Sim</label>
                                    <input id="exibirmarcadaguanao" class="form-check-input" type="radio" value="0" name="exibirmarcadagua" {{(old('exibirmarcadagua') == '0' ? 'checked' : '')}}>
                                    <label for="exibirmarcadaguanao" class="form-check-label">Não</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">   
                            <div class="form-group text-muted">
                                <label class="labelforms"><b>Legenda da Imagem de Capa</b></label>
                                <input type="text" class="form-control"  wire:model="caption_img_cover">
                            </div>                                                    
                        </div>
                    </div>

                    <hr class="my-4 border-gray-300">

                    <label class="block font-semibold mb-2 mt-2 text-muted">📁 Upload de Imagens:</label>
                    <input type="file" wire:model="images" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0 file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple/>
        
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
        
                    
                    <div x-data="{ showModal: false, imageUrl: null }">
                        <div class="flex flex-wrap gap-4 mt-4">
                            {{-- Imagens já salvas (vindas do banco) --}}
                                @foreach ($manifest->images ?? [] as $savedImage)
                                <div class="relative">
                                    <img src="{{ Storage::url($savedImage->path) }}" class="w-40 h-40 object-cover rounded border cursor-pointer"
                                        @click="showModal = true; imageUrl = '{{ Storage::url($savedImage->path) }}'">
                                    <button type="button"
                                            wire:click="removeSavedImage({{ $savedImage->id }})"
                                            class="absolute top-1 right-1 w-6 h-6 flex items-center justify-center bg-red-500 text-white rounded-full text-xs hover:bg-red-600">
                                        ✕
                                    </button>
                                </div>
                            @endforeach
    
                            {{-- Imagens recém-uploadadas via Livewire --}}
                            @foreach ($images as $index => $image)
                                <div class="relative">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded border cursor-pointer"
                                        @click="showModal = true; imageUrl = '{{ $image->temporaryUrl() }}'">
                                    <button type="button"
                                            wire:click="removeTempImage({{ $index }})"
                                            class="absolute top-1 right-1 w-6 h-6 flex items-center justify-center bg-red-500 text-white rounded-full text-xs hover:bg-red-600">
                                        ✕
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <!-- Modal de imagem -->
                        <div x-show="showModal" x-cloak
                            class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[9999]"
                            x-transition>
                            <div class="relative">
                                <img :src="imageUrl" class="max-w-[70vw] max-h-[70vh] object-contain mx-auto rounded shadow-lg">
                                <button type="button" @click="showModal = false"
                                        class="absolute top-2 right-2 text-white text-xl bg-black bg-opacity-50 rounded-full px-2 py-1">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="tab === 'seo'" x-transition>
                <div class="bg-white">

                </div>
            </div>

        </form>
    </div>
</div>
