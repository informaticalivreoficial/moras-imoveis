@extends("web.{$configuracoes->template}.master.master")

@section('content')

<div class="sub-banner" style="background: rgba(0, 0, 0, 0.04) url({{$configuracoes->gettopodosite()}}) top left repeat;">
    <div class="overlay">
        <div class="container">
            <div class="breadcrumb-area">
                <h1>{{$imovel->titulo}}</h1>
                <p style="color: aliceblue;" class="py-1">{{$imovel->headline}}</p>
                <ul class="breadcrumbs">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Imóveis - {{$imovel->titulo}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Properties details page start -->
<div class="properties-details-page content-area">
    <div class="container">
        <div class="row mb-20">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 wow fadeInUp delay-03s">
                <!-- Header properties start -->
                <div class="heading-properties clearfix sidebar-widget">
                    <div class="pull-left">
                        <h4><b>{{$imovel->titulo}}</b></h4>                        
                        <p>
                            <i class="fa fa-map-marker"></i>{{$imovel->bairro}} - {{getCidadeNome($imovel->cidade, 'cidades')}}
                        </p>                                                
                    </div>
                    <div class="pull-right">  

                        <h3>
                            <span>
                                @if ($imovel->venda == true && $imovel->locacao == true)
                                    Venda/Locação
                                @elseif($imovel->venda == true && $imovel->locacao == false)
                                    Venda
                                @else
                                    Locação
                                @endif
                            </span>
                        </h3>
                        @if ($imovel->referencia)
                            <h5>
                                <b>Referência:</b> {{$imovel->referencia}}
                            </h5>
                        @endif                        
                    </div>
                    
                </div>                
                   
                <div class="property-img">
                    <img src="{{$imovel->coverSlideGallery()}}" alt="{{$imovel->titulo}}" class="img-fluid w-100">
                       
                    {{-- <div class="property-overlay">
                        @if($imovel->images()->get()->count())
                                                
                                @foreach($imovel->images()->get() as $image)                    
                                    <a href="{{ $image->url_image }}" class="hidden"></a>                              
                                @endforeach
                            
                        @endif
                    </div> --}}


                    <div class="row">
                        @if($imovel->images()->get()->count())
                            @foreach($imovel->images()->get() as $image)                    
                                <div class="col-lg-2 p-1">
                                    <div class="portfolio-item car-magnify-gallery" style="margin-bottom: 0px;">
                                        <a href="{{ $image->url_image }}">
                                            <img src="{{ $image->url_cropped_slide_gallery }}" alt="{{$imovel->titulo}}">
                                        </a>
                                        <div class="portfolio-content">
                                            <div class="portfolio-content-inner">
                                                
                                            </div>
                                        </div>
                                    </div>  
                                </div>                              
                            @endforeach
                        @endif
                    </div>
                </div>

                
                
                

                <div class="main-title-2">
                    <h1 style="margin-top:10px;"><span>Informações</span></h1>
                    <br />
                    <!-- Social list -->
                    <div id="shareIcons"></div>            
                </div>
               
                <div class="heading-properties clearfix sidebar-widget sw2">
                    <div class="pull-left">
                        @if($imovel->exibivalores == true)
                            <p><b>IPTU:</b> R$ {{str_replace(',00', '', $imovel->iptu)}} {!! ($imovel->condominio != '' ? '| <b>Condomínio:</b> R$' . str_replace(',00', '', $imovel->condominio) : '') !!}</p>
                            @if($imovel->venda == true && $imovel->locacao == false)
                                <p><b>Valor do Imóvel:</b> R${{str_replace(',00', '', $imovel->valor_venda)}}</p>
                            @elseif($imovel->locacao == true && $imovel->venda == false)
                                <p><b>Valor do Aluguel:</b> R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}</p>
                            @else
                                @if($imovel->venda == true && !empty($imovel->valor_venda) && $imovel->valor_locacao == true && !empty($imovel->valor_locacao))
                                    <p><b>Valor do Imóvel:</b> R${{ str_replace(',00', '', $imovel->valor_venda) }} <br>
                                        <b>ou Valor do Aluguel:</b> R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}</p>
                                @elseif($imovel->venda == true && !empty($imovel->valor_venda))
                                    <p><b>Valor do Imóvel:</b> R${{ str_replace(',00', '', $imovel->valor_venda) }}</p>
                                @elseif($imovel->locacao == true && !empty($imovel->valor_locacao))
                                    <p><b>Valor do Aluguel:</b> R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}</p>
                                @else
                                    <p>Entre em contato com a nossa equipe comercial!</p>
                                @endif
                            @endif                            
                        @endif 
                    </div>                    
                </div>

                <!-- Property description start -->
                <div class="property-description tabbing tabbing-box tb2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Descrição</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Condições do Imóvel</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Estrutura</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="accordion accordion-flush" id="accordionFlushExample7">
                                <div class="accordion-item">
                                    <div class="properties-description">                                            
                                        {!! $imovel->descricao !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="accordion accordion-flush" id="accordionFlushExample2">
                                <div class="accordion-item">
                                    <div class="properties-condition">                                            
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <ul class="condition">
                                                    @if ($imovel->dormitorios)
                                                        <li>
                                                            <i class="flaticon-bed"></i> {{$imovel->dormitorios}} Dormitórios
                                                        </li>
                                                    @endif
                                                    @if ($imovel->suites)
                                                        <li>
                                                            <i class="flaticon-bed"></i> {{$imovel->suites}} Suítes
                                                        </li>
                                                    @endif                                                        
                                                    @if ($imovel->area_total)
                                                        <li>
                                                            <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>{{$imovel->area_total}}{{$imovel->medidas}} Área total
                                                        </li>
                                                    @endif                                                        
                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <ul class="condition">
                                                    @if ($imovel->banheiros)
                                                        <li>
                                                            <i class="flaticon-bed"></i> {{$imovel->banheiros}} Banheiros
                                                        </li>
                                                    @endif
                                                    @if ($imovel->salas)
                                                        <li>
                                                            <i class="flaticon-building"></i> {{$imovel->salas}} Salas
                                                        </li>
                                                    @endif                                                       
                                                    @if ($imovel->area_util)
                                                        <li>
                                                            <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>{{$imovel->area_util}}{{$imovel->medidas}} Área útil
                                                        </li>
                                                    @endif                                                       
                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <ul class="condition">
                                                    @if ($imovel->garagem)
                                                        <li>
                                                            <i class="flaticon-vehicle"></i> {{$imovel->garagem}} Garagem
                                                        </li>
                                                    @endif
                                                    @if ($imovel->garagem_coberta)
                                                        <li>
                                                            <i class="flaticon-vehicle"></i> {{$imovel->garagem_coberta}} Garagem coberta
                                                        </li>
                                                    @endif                                                        
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="accordion accordion-flush" id="accordionFlushExample3">
                                <div class="accordion-item">
                                    <div class="properties-amenities">                                            
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <ul class="amenities">
                                                    @if($imovel->ar_condicionado == true)
                                                        <li><i class="fa fa-check-square"></i>Ar Condicionado></li>
                                                    @endif

                                                    @if($imovel->aquecedor_solar == true)
                                                        <li><i class="fa fa-check-square"></i>Aquecedor Solar</li>
                                                    @endif

                                                    @if($imovel->armarionautico == true)
                                                        <li><i class="fa fa-check-square"></i>Armário Náutico</li>
                                                    @endif

                                                    @if($imovel->balcaoamericano == true)
                                                        <li><i class="fa fa-check-square"></i>Balcão Americano</li>
                                                    @endif

                                                    @if($imovel->banheira == true)
                                                        <li><i class="fa fa-check-square"></i>Banheira</li>
                                                    @endif 
                                                    
                                                    @if($imovel->elevador == true)
                                                        <li><i class="fa fa-check-square"></i>Elevador</li>
                                                    @endif

                                                    @if($imovel->escritorio == true)
                                                        <li><i class="fa fa-check-square"></i>Escritório</li>
                                                    @endif

                                                    @if($imovel->espaco_fitness == true)
                                                        <li><i class="fa fa-check-square"></i>Espaço Fitness</li>
                                                    @endif

                                                    @if($imovel->estacionamento == true)
                                                        <li><i class="fa fa-check-square"></i>Estacionamento</li>
                                                    @endif

                                                    @if($imovel->fornodepizza == true)
                                                        <li><i class="fa fa-check-square"></i>Forno de Pizza</li>
                                                    @endif

                                                    @if($imovel->quadrapoliesportiva == true)
                                                        <li><i class="fa fa-check-square"></i>Quadra poliesportiva</li>
                                                    @endif

                                                    @if($imovel->quintal == true)
                                                        <li><i class="fa fa-check-square"></i>Quintal</li>
                                                    @endif

                                                    @if($imovel->sauna == true)
                                                        <li><i class="fa fa-check-square"></i>Sauna</li>
                                                    @endif

                                                    @if($imovel->saladetv == true)
                                                        <li><i class="fa fa-check-square"></i>Sala de TV</li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <ul class="amenities">
                                                    @if($imovel->banheirosocial == true)
                                                        <li><i class="fa fa-check-square"></i>Banheiro Social</li>
                                                    @endif

                                                    @if($imovel->bar == true)
                                                        <li><i class="fa fa-check-square"></i>Bar Social</li>
                                                    @endif

                                                    @if($imovel->biblioteca == true)
                                                        <li><i class="fa fa-check-square"></i>Biblioteca</li>
                                                    @endif

                                                    @if($imovel->brinquedoteca == true)
                                                        <li><i class="fa fa-check-square"></i>Brinquedoteca</li>
                                                    @endif

                                                    @if($imovel->condominiofechado == true)
                                                        <li><i class="fa fa-check-square"></i>Condomínio fechado</li>
                                                    @endif 
                                                    
                                                    @if($imovel->geradoreletrico == true)
                                                        <li><i class="fa fa-check-square"></i>Gerador elétrico</li>
                                                    @endif

                                                    @if($imovel->interfone == true)
                                                        <li><i class="fa fa-check-square"></i>Interfone</li>
                                                    @endif

                                                    @if($imovel->jardim == true)
                                                        <li><i class="fa fa-check-square"></i>Jardim</li>
                                                    @endif

                                                    @if($imovel->lareira == true)
                                                        <li><i class="fa fa-check-square"></i>Lareira</li>
                                                    @endif

                                                    @if($imovel->lavabo == true)
                                                        <li><i class="fa fa-check-square"></i>Lavabo</li>
                                                    @endif

                                                    @if($imovel->salaodefestas == true)
                                                        <li><i class="fa fa-check-square"></i>Salão de Festas</li>
                                                    @endif

                                                    @if($imovel->salaodejogos == true)
                                                        <li><i class="fa fa-check-square"></i>Salão de Jogos</li>
                                                    @endif

                                                    @if($imovel->zeladoria == true)
                                                        <li><i class="fa fa-check-square"></i>Serviço de Zeladoria</li>
                                                    @endif

                                                    @if($imovel->sistemadealarme == true)
                                                        <li><i class="fa fa-check-square"></i>Sistema de alarme</li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <ul class="amenities">
                                                    @if($imovel->cozinha_americana == true)
                                                        <li><i class="fa fa-check-square"></i>Cozinha Americana</li>
                                                    @endif

                                                    @if($imovel->cozinha_planejada == true)
                                                        <li><i class="fa fa-check-square"></i>Cozinha Planejada</li>
                                                    @endif

                                                    @if($imovel->churrasqueira == true)
                                                        <li><i class="fa fa-check-square"></i>Churrasqueira</li>
                                                    @endif

                                                    @if($imovel->dispensa == true)
                                                        <li><i class="fa fa-check-square"></i>Despensa</li>
                                                    @endif

                                                    @if($imovel->edicula == true)
                                                        <li><i class="fa fa-check-square"></i>Edicula</li>
                                                    @endif    
                                                    
                                                    @if($imovel->lavanderia == true)
                                                        <li><i class="fa fa-check-square"></i>Lavanderia</li>
                                                    @endif

                                                    @if($imovel->mobiliado == true)
                                                        <li><i class="fa fa-check-square"></i>Mobiliado</li>
                                                    @endif

                                                    @if($imovel->pertodeescolas == true)
                                                        <li><i class="fa fa-check-square"></i>Perto de Escolas</li>
                                                    @endif

                                                    @if($imovel->piscina == true)
                                                        <li><i class="fa fa-check-square"></i>Piscina</li>
                                                    @endif

                                                    @if($imovel->portaria24hs == true)
                                                        <li><i class="fa fa-check-square"></i>Portaria 24 Horas</li>
                                                    @endif

                                                    @if($imovel->permiteanimais == true)
                                                        <li><i class="fa fa-check-square"></i>Permite animais</li>
                                                    @endif

                                                    @if($imovel->varandagourmet == true)
                                                        <li><i class="fa fa-check-square"></i>Varanda Gourmet</li>
                                                    @endif

                                                    @if($imovel->vista_para_mar == true)
                                                        <li><i class="fa fa-check-square"></i>Vista para o Mar</li>
                                                    @endif

                                                    @if($imovel->ventilador_teto == true)
                                                        <li><i class="fa fa-check-square"></i>Ventilador de Teto</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Property description end -->

                <!-- Properties description start -->
                <div class="properties-description mb-20">
                    <hr>                        
                    <p>*{{$imovel->notasadicionais}}</p>
                </div>
                <!-- Properties description end -->

                @if ($imovel->exibirendereco == true)
                    <div class="location sidebar-widget">
                        <div class="map">
                            <div class="main-title-2">
                                <h1><span>Localização</span></h1>
                            </div>
                            <div id="map" class="contact-map" style="position: relative; overflow: hidden;">
                                <div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px;">
                                    {!!$imovel->mapadogoogle!!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif                

                <!-- Contact 1 start -->
                <div class="contact-1 sidebar-widget mb-30" style="padding: 10px;box-sizing: border-box !important;">
                    @if ($imovel->url_booking || $imovel->url_arbnb)
                        <p class="pb-3 pt-3 text-center">
                            @if ($imovel->url_booking)
                                <a href="{{$imovel->url_booking}}" target="_blank">
                                    <img class="img-shadow mb-4" src="{{url(asset('frontend/'.$configuracoes->template.'/img/btn-arbnb.jpg'))}}" alt="Airbnb">
                                </a>                                
                            @endif
                            @if ($imovel->url_arbnb)
                                <a href="{{$imovel->url_arbnb}}" target="_blank">
                                    <img class="img-shadow mb-4" src="{{url(asset('frontend/'.$configuracoes->template.'/img/btn-booking.jpg'))}}" alt="Booking">
                                </a>                                
                            @endif
                        </p>
                    @endif
                    <div class="main-title-2">
                        <h1>Consultar este imóvel</h1>
                    </div>
                    <div class="contact-form">
                        <form action="" method="POST" class="j_formsubmit" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div id="js-contact-result"></div>
                                    <!-- HONEYPOT -->
                                    <input type="hidden" class="noclear" name="bairro" value="" />
                                    <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group name">
                                        <input type="text" name="nome" class="form-control" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group email">
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>                                
                                <div class="col-md-12">
                                    <div class="form-group message">
                                        <textarea  class="form-control" name="mensagem">Quero ter mais informações sobre este imóvel, {{$imovel->titulo}} - {{$imovel->referencia}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="send-btn">
                                        <button type="submit" id="js-contact-btn" class="button-md button-theme btn-3">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Contact 1 end -->

                <!-- Properties details section start -->
                <div class="sidebar-widget advanced-search d-lg-none">
                    <div class="main-title-2">
                        <h1>Busca Avançada</h1>
                    </div>
                    <form action="{{ route('web.filter') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="search" class="mb-1 text-front">Comprar ou Alugar?</label>
                            <select class="selectpicker search-fields" name="filter_search" id="search" title="Escolha..." data-index="1" data-action="{{ route('web.main-filter.search') }}">
                                <option value="venda">Comprar</option>
                                <option value="locacao">Alugar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoria" class="mb-1 text-front">O que você procura?</label>
                            <select class="selectpicker search-fields" name="filter_categoria" id="categoria" title="Escolha..." data-index="2" data-action="{{ route('web.main-filter.categoria') }}">
                                <option disabled>Selecione o filtro anterior</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo" class="mb-1 text-front">Qual o tipo do imóvel?</label>
                            <select name="filter_tipo" id="tipo" class="selectpicker search-fields" title="Escolha..." multiple data-actions-box="true" data-index="3" data-action="{{ route('web.main-filter.tipo') }}">
                                <option disabled>Selecione o filtro anterior</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="search" class="mb-1 text-front">Onde você quer?</label>
                            <select name="filter_bairro" id="bairro" class="selectpicker search-fields" title="Escolha..." multiple data-actions-box="true" data-index="4" data-action="{{ route('web.main-filter.bairro') }}">
                                <option disabled>Selecione o filtro anterior</option>
                            </select>
                        </div>
                        <div class="form_advanced" style="display: none;">
                            <div class="form-group">
                                <label for="dormitorios" class="mb-1 text-front">Dormitórios</label>
                                <select name="filter_dormitorios" id="dormitorios" class="selectpicker search-fields" title="Escolha..." data-index="5" data-action="{{ route('web.main-filter.dormitorios') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="suites" class="labelforms mb-1"><b>Suítes</b></label>
                                <select class="selectpicker search-fields" name="filter_suites" id="suites" title="Escolha..." data-index="6" data-action="{{ route('web.main-filter.suites') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>   
                            <div class="form-group">
                                <label for="banheiros" class="labelforms mb-1"><b>Banheiros</b></label>
                                <select class="selectpicker search-fields" name="filter_banheiros" id="banheiros" title="Escolha..." data-index="7" data-action="{{ route('web.main-filter.banheiros') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="garagem" class="labelforms mb-1"><b>Garagem</b></label>
                                <select class="selectpicker search-fields" name="filter_garagem" id="garagem" title="Escolha..." data-index="8" data-action="{{ route('web.main-filter.garagem') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="base" class="labelforms mb-1"><b>Preço Base</b></label>
                                <select class="selectpicker search-fields" name="filter_base" id="base" title="Escolha..." data-index="9" data-action="{{ route('web.main-filter.priceBase') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="limit" class="labelforms mb-1"><b>Preço Limite</b></label>
                                <select class="selectpicker search-fields" name="filter_limit" id="limit" title="Escolha..." data-index="10" data-action="{{ route('web.main-filter.priceLimit') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>                         
                        </div>
                        <div class="form-group">
                            <a href="" class="text-front open_filter">Filtro Avançado &darr;</a>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="button-md button-theme btn-3 w-100">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!-- Properties details section end -->
                
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <!-- Sidebar start -->
                <div class="sidebar right">
                    <!-- Advanced search start -->
                    <div class="sidebar-widget advanced-search as2">
                        <div class="main-title-2">
                            <h1>Busca Avançada</h1>
                        </div>
                        <form action="{{ route('web.filter') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="search" class="mb-1 text-front">Comprar ou Alugar?</label>
                                <select class="selectpicker search-fields" name="filter_search" id="search" title="Escolha..." data-index="1" data-action="{{ route('web.main-filter.search') }}">
                                    <option value="venda">Comprar</option>
                                    <option value="locacao">Alugar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categoria" class="mb-1 text-front">O que você procura?</label>
                                <select class="selectpicker search-fields" name="filter_categoria" id="categoria" title="Escolha..." data-index="2" data-action="{{ route('web.main-filter.categoria') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tipo" class="mb-1 text-front">Qual o tipo do imóvel?</label>
                                <select name="filter_tipo" id="tipo" class="selectpicker search-fields" title="Escolha..." multiple data-actions-box="true" data-index="3" data-action="{{ route('web.main-filter.tipo') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="search" class="mb-1 text-front">Onde você quer?</label>
                                <select name="filter_bairro" id="bairro" class="selectpicker search-fields" title="Escolha..." multiple data-actions-box="true" data-index="4" data-action="{{ route('web.main-filter.bairro') }}">
                                    <option disabled>Selecione o filtro anterior</option>
                                </select>
                            </div>
                            <div class="form_advanced" style="display: none;">
                                <div class="form-group">
                                    <label for="dormitorios" class="mb-1 text-front">Dormitórios</label>
                                    <select name="filter_dormitorios" id="dormitorios" class="selectpicker search-fields" title="Escolha..." data-index="5" data-action="{{ route('web.main-filter.dormitorios') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="suites" class="labelforms mb-1"><b>Suítes</b></label>
                                    <select class="selectpicker search-fields" name="filter_suites" id="suites" title="Escolha..." data-index="6" data-action="{{ route('web.main-filter.suites') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>   
                                <div class="form-group">
                                    <label for="banheiros" class="labelforms mb-1"><b>Banheiros</b></label>
                                    <select class="selectpicker search-fields" name="filter_banheiros" id="banheiros" title="Escolha..." data-index="7" data-action="{{ route('web.main-filter.banheiros') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="garagem" class="labelforms mb-1"><b>Garagem</b></label>
                                    <select class="selectpicker search-fields" name="filter_garagem" id="garagem" title="Escolha..." data-index="8" data-action="{{ route('web.main-filter.garagem') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="base" class="labelforms mb-1"><b>Preço Base</b></label>
                                    <select class="selectpicker search-fields" name="filter_base" id="base" title="Escolha..." data-index="9" data-action="{{ route('web.main-filter.priceBase') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="limit" class="labelforms mb-1"><b>Preço Limite</b></label>
                                    <select class="selectpicker search-fields" name="filter_limit" id="limit" title="Escolha..." data-index="10" data-action="{{ route('web.main-filter.priceLimit') }}">
                                        <option disabled>Selecione o filtro anterior</option>
                                    </select>
                                </div>                         
                            </div>
                            <div class="form-group">
                                <a href="" class="text-front open_filter">Filtro Avançado &darr;</a>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="button-md button-theme btn-3 w-100">Pesquisar</button>
                            </div>
                        </form>
                    </div>
                    <!-- Advanced search end -->

                   

                    <!-- Helping center start -->
                    <div class="sidebar-widget helping-box clearfix">
                        <div class="main-title-2">
                            <h1>Atendimento</h1>
                        </div>                        
                        @if ($configuracoes->telefone)
                            <div class="helping-center">
                                <div class="icon"><i class="fa fa-phone"></i></div>
                                <h4>Telefone</h4>
                                <p><a href="tel:{{$configuracoes->telefone}}">{{$configuracoes->telefone}}</a> </p>
                            </div>
                        @endif
                        @if ($configuracoes->celular)
                            <div class="helping-center">
                                <div class="icon"><i class="fa fa-phone"></i></div>
                                <h4>Telefone</h4>
                                <p><a href="tel:{{$configuracoes->celular}}">{{$configuracoes->celular}}</a> </p>                                
                            </div>
                        @endif
                        @if ($configuracoes->whatsapp)
                            <div class="helping-center">
                                <div class="icon"><i class="fa fa-whatsapp"></i></div>
                                <h4>WhatsApp</h4>
                                <p><a href="{{getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->name)}}">{{$configuracoes->whatsapp}}</a> </p>
                            </div>
                        @endif                        
                    </div>
                    <!-- Helping center end -->

                    

                </div>
                <!-- Sidebar end -->
            </div>
        </div>
    </div>

    @if (!empty($imoveis) && $imoveis->count() > 0)
        <div class="comon-slick recently-properties">
            <div class="container">
                <div class="main-title-2">
                    <h1><span>Veja Também</span></h1>
                </div>
                <div class="slick row comon-slick-inner" data-slick='{"slidesToShow": 4, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}}]}'>
                    @foreach ($imoveis as $imovel)
                        <div class="item slide-box">
                            <div class="property-2">
                                <div class="property-inner">
                                    <div class="property-overflow">
                                        <div class="property-photo">
                                            <img src="{{$imovel->cover()}}" alt="rp" class="img-fluid">
                                            <div class="listing-badges">
                                                <span class="featured active">{{$type}}</span>
                                            </div>
                                            @if($imovel->exibivalores == true)
                                                <div class="price-ratings">
                                                    @if($imovel->venda == true && $imovel->locacao == false)
                                                        <div class="price">R$ {{str_replace(',00', '', $imovel->valor_venda)}}</div>                                                        
                                                    @elseif($imovel->locacao == true && $imovel->venda == false)
                                                        <div class="price">R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}</div>
                                                    @else
                                                        @if($imovel->venda == true && !empty($imovel->valor_venda) && $imovel->valor_locacao == true && !empty($imovel->valor_locacao))
                                                            <div class="price">
                                                                Venda: R${{ str_replace(',00', '', $imovel->valor_venda) }}<br>
                                                                Aluguel: R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}
                                                            </div> 
                                                        @elseif($imovel->venda == true && !empty($imovel->valor_venda) && $imovel->locacao == false)
                                                            <div class="price">R${{ str_replace(',00', '', $imovel->valor_venda) }}</div>
                                                        @elseif($imovel->locacao == true && !empty($imovel->valor_locacao) && $imovel->venda == false)
                                                            <div class="price">R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}</div>
                                                        @else
                                                            <div class="price">Sob Consulta</div>
                                                        @endif
                                                    @endif 
                                                </div>
                                            @endif                                            
                                        </div>
                                    </div>
                                    <!-- content -->
                                    <div class="content">
                                        <!-- title -->
                                        <h4 class="title">
                                            <a href="{{route(($imovel->venda == true ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $imovel->slug])}}">{{$imovel->titulo}}</a>
                                        </h4>
                                        <!-- Property address -->
                                        <h3 class="property-address">
                                            <a href="{{route(($imovel->venda == true ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $imovel->slug])}}">
                                                <i class="fa fa-map-marker"></i>{{$imovel->bairro}} - {{getCidadeNome($imovel->cidade, 'cidades')}}
                                            </a>
                                        </h3>
                                    </div>
                                    <!-- Facilities List -->
                                    <ul class="facilities-list clearfix">
                                        @if ($imovel->area_util)
                                            <li>
                                                <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                                <span>{{$imovel->area_util}}{{$imovel->medidas}}</span>
                                            </li>
                                        @endif                                        
                                        @if ($imovel->dormitorios)
                                            <li>
                                                <i class="flaticon-bed"></i>
                                                <span>{{$imovel->dormitorios}} Dorm</span>
                                            </li>
                                        @endif  
                                        @if ($imovel->banheiros)
                                            <li>
                                                <i class="flaticon-holidays"></i>
                                                <span>{{$imovel->banheiros}} Banh</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach                    
                </div>
            </div>
        </div>
    @endif
    
</div>
<!-- Properties details page end -->

@endsection

@section('css')
<link rel="stylesheet" href="{{url(asset('frontend/'.$configuracoes->template.'/js/jsSocials/jssocials.css'))}}" />
<link rel="stylesheet" href="{{url(asset('frontend/'.$configuracoes->template.'/js/jsSocials/jssocials-theme-flat.css'))}}" />
    <style>
        .portfolio-item img {
            width: 120px;
            max-height:79px !important;
        }
        .img-shadow {
            border:2px solid #fff;
            box-shadow: 10px 10px 5px #ccc;
            -moz-box-shadow: 10px 10px 5px #ccc;
            -webkit-box-shadow: 10px 10px 5px #ccc;
            -khtml-box-shadow: 10px 10px 5px #ccc;
        }
    </style>    
@endsection

@section('js')
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jsSocials/jssocials.min.js'))}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#shareIcons').jsSocials({
            //url: "http://www.google.com",
            showLabel: false,
            showCount: false,
            shareIn: "popup",
            shares: ["email", "twitter", "facebook", "whatsapp"]
        });
        $('.shareIcons').jsSocials({
            //url: "http://www.google.com",
            showLabel: false,
            showCount: false,
            shareIn: "popup",
            shares: ["email", "twitter", "facebook", "whatsapp"]
        });

        $('.open_filter').on('click', function (event) {
            event.preventDefault();

            box = $(".form_advanced");
            button = $(this);

            if (box.css("display") !== "none") {
                button.text("Filtro Avançado ↓");
            } else {
                button.text("✗ Fechar");
            }

            box.slideToggle();
        });

        $('body').on('change', 'select[name*="filter_"]', function () {

        var search = $(this);
        var nextIndex = $(this).data('index') + 1;

        $.post(search.data('action'), {search: search.val()}, function(response){

                if(response.status === 'success') {

                    $('select[data-index="' + nextIndex + '"]').empty();

                    $.each(response.data, function(key, value){
                        $('select[data-index="' + nextIndex + '"]').append(
                            $('<option>', {
                                value: value,
                                text: value
                            })
                        );
                    });

                    $.each($('select[name*="filter_"]'), function(index, element){

                        if($(element).data('index') >= nextIndex + 1){
                            $(element).empty().append(
                                $('<option>', {
                                    text: 'Selecione o filtro anterior',
                                    disabled: true
                                })
                            );
                        }

                    });

                    $('.selectpicker').selectpicker('refresh');
                }

                if(response.status === 'fail') {

                    if($(element).data('index') >= nextIndex){
                        $(element).empty().append(
                            $('<option>', {
                                text: 'Selecione o filtro anterior',
                                disabled: true
                            })
                        );
                    }

                    $('.selectpicker').selectpicker('refresh');
                }

            }, 'json');
        });

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.sendEmail') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-contact-btn").attr("disabled", true);
                    form.find('#js-contact-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(resposta){
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-40}, 'slow');
                    if(resposta.error){
                        form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-contact-result').html('<div class="alert alert-success error-msg">'+ resposta.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('textarea[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html("Enviar");                                
                }

            });

            return false;
        });
        

        });
    
</script>
@endsection