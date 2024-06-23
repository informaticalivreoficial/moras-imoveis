@extends("web.{$configuracoes->template}.master.master")

@section('content')

@if (!empty($slides) && $slides->count() > 0)
    <div class="banner">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            
            <div class="carousel-inner" role="listbox">  
                @foreach ($slides as $key => $slide)       
                    @php $active = ($key == '0' ? ' active' : '');@endphp   
                    <div class="item banner-max-height {{$active}}">
                        <img src="{{$slide->getimagem()}}" alt="{{$slide->titulo}}">
                        <div class="carousel-caption banner-slider-inner">
                            <div class="banner-content">                        
                                <h1 data-animation="animated fadeInDown delay-05s">{{$slide->titulo}}</h1>
                                @if ($slide->subtitulo)
                                    <p data-animation="animated fadeInUp delay-1s">{{$slide->subtitulo}}</p>
                                @endif
                                <a {{($slide->target == 1 ? 'target="_blank"' : '')}} href="{{$slide->link}}" title="{{$slide->titulo}}" class="btn button-md button-theme" data-animation="animated fadeInUp delay-15s">Clique aqui!</a>                                
                            </div>
                        </div>
                    </div> 
                @endforeach
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="slider-mover-left" aria-hidden="true">
                <i class="fa fa-angle-left"></i>
                </span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="slider-mover-right" aria-hidden="true">
                <i class="fa fa-angle-right"></i>
                </span>
                <span class="sr-only">Próximo</span>
            </a>
        </div>
    </div>
@endif

{{--SEARCH FORM--}}

<!-- RESULTADO DO FILTRO DE BUSCA  -->  
<div class="resultado"></div>

@if (!empty($destaque) && $destaque->count() > 0)
    <div class="properties-section property-big content-area" style="padding-bottom:0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="property property-hp row g-0 fp2 clearfix wow fadeInUp delay-03s">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <!-- Property img -->
                            <div class="property-img">
                                <div class="property-tag button alt featured">Destaque</div>
                                <div class="property-tag button sale">{{($destaque->sale == 1 ? 'Venda' : 'Locação')}}</div>
                                @if($destaque->display_values == 1)
                                    @if(!empty($type) && $type == 'venda')
                                        <div class="property-price">R${{str_replace(',00', '', $destaque->sale_value)}}</div>
                                    @elseif($destaque->location == 1 && $destaque->sale == 0)
                                        <div class="property-price"><b>Aluguel:</b> R${{ str_replace(',00', '', $destaque->rental_value) }}/{{$destaque->getLocationPeriod()}}</div>
                                    @else
                                        @if($destaque->sale == 1 && !empty($destaque->sale_value) && $destaque->location == 1 && !empty($destaque->rental_value))
                                                <div class="property-price"><b>Valor do Imóvel:</b> R${{ str_replace(',00', '', $destaque->sale_value) }} <br>
                                                <b>ou Valor do Aluguel:</b> R${{ str_replace(',00', '', $destaque->rental_value) }}/{{$destaque->getLocationPeriod()}}</div>
                                        @elseif($destaque->sale == 1 && !empty($destaque->sale_value))
                                            <div class="property-price">R${{ str_replace(',00', '', $destaque->sale_value) }}</div>
                                        @elseif($destaque->location == 1 && !empty($destaque->rental_value))
                                            <div class="property-price"><b>Aluguel:</b> R${{ str_replace(',00', '', $destaque->rental_value) }}/{{$destaque->getLocationPeriod()}}</div>
                                        @else
                                            <div class="property-price">Sob Consulta!</div>
                                        @endif
                                    @endif
                                @endif
                                <img src="{{--$destaque->cover()--}}https://informatica-livre.s3.us-east-2.amazonaws.com/superimoveis/imoveis/5282bcb2-59b0-47ec-9efb-932faba32ea6/444/aluguel-temporada-16867535339626.jpg" alt="{{$destaque->title}}" class="img-fluid w-100">
                                <div class="property-overlay">
                                    <a href="{{ route(($destaque->location == 1 ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $destaque->slug]) }}" class="overlay-link">
                                        <i class="fa fa-link"></i>
                                    </a>
                                    @if ($destaque->youtube_video)
                                        <a class="overlay-link property-video" title="{{$destaque->title}}" data-embed="{{getEmbedYoutube($destaque->youtube_video)}}">
                                            <i class="fa fa-video-camera"></i>
                                        </a>
                                    @endif
                                    <div class="property-magnify-gallery">
                                        <a href="{{$destaque->cover()}}" class="overlay-link">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                        @if($destaque->images()->get()->count())
                                            @foreach($destaque->images()->get() as $image)
                                                <a href="{{ $image->url_image }}" class="hidden"></a>                             
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 property-content">
                            <div class="info">
                                <!-- title -->
                                <h1 class="title">
                                    <a href="{{ route(($destaque->location == 1 ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $destaque->slug]) }}">{{$destaque->title}}</a>
                                </h1>
                                <!-- Property address -->
                                <h3 class="property-address">
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-map-marker"></i>{{$destaque->neighborhood}} - {{$destaque->city}}
                                    </a>
                                </h3>
                                <!-- Facilities List -->
                                <ul class="facilities-list clearfix">
                                    @if ($destaque->useful_area)
                                        <li>
                                            <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                            <span>{{$destaque->useful_area}}{{$destaque->measures}} Área útil</span>
                                        </li>
                                    @endif
                                    @if ($destaque->total_area)
                                        <li>
                                            <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                            <span>{{$destaque->total_area}}{{$destaque->measures}} Área total</span>
                                        </li>
                                    @endif
                                    @if ($destaque->dormitories)
                                        <li>
                                            <i class="flaticon-bed"></i>
                                            <span>{{$destaque->dormitories}} Dormitórios</span>
                                        </li>
                                    @endif
                                    @if ($destaque->bathrooms)
                                        <li>
                                            <i class="flaticon-holidays"></i>
                                            <span>{{$destaque->bathrooms}} Banheiros</span>
                                        </li>
                                    @endif                                    
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>
                                            @php
                                            if(!empty($destaque->garage) && !empty($destaque->covered_garage)){
                                                $g = $destaque->garage + $destaque->covered_garage;
                                                echo $g.' Garagem';
                                            }elseif(!empty($destaque->garage) && empty($destaque->covered_garage)){
                                                echo $destaque->garage.' Garagem';
                                            }else{
                                                echo $destaque->covered_garage.' Garagem';
                                            }
                                            @endphp
                                        </span>
                                    </li>
                                </ul>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (!empty($propertiesForSale) && $propertiesForSale->count() > 0)
    <div class="properties-section-body content-area">
        <div class="container">
            <!-- TÍTULO  -->
            <div class="main-title">
                <h1>Imóveis a Venda</h1>
            </div>
            <div class="row">   
                @foreach ($propertiesForSale as $sale)             
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp delay-03s">
                        <div class="property" style="min-height: 440px !important;">
                            <!-- Property img -->
                            <div class="property-img">
                                <div class="property-tag button alt featured">Referência: {{$sale->reference}}</div>
                                <div class="property-tag button sale">{{$sale->type}}</div>
                                @if($sale->display_values == 1)
                                    <div class="property-price">R$ {{str_replace(',00', '', $sale->sale_value)}}</div>
                                @endif 
                                <img style="min-height:262px !important;max-height: 262px !important;max-width: 100%;" src="{{--$sale->cover()--}}https://informatica-livre.s3.us-east-2.amazonaws.com/superimoveis/imoveis/5282bcb2-59b0-47ec-9efb-932faba32ea6/444/aluguel-temporada-16867535339626.jpg" alt="{{$sale->title}}" class="img-responsive">
                                <div class="property-overlay">
                                    <a href="{{route('web.buyProperty', ['slug' => $sale->slug])}}" class="overlay-link">
                                        <i class="fa fa-link"></i>
                                    </a>                                       
                                
                                    <div class="property-magnify-gallery"> 
                                        @if($sale->images()->get()->count())
                                            <a href="{{$sale->cover()}}" class="overlay-link"><i class="fa fa-expand"></i></a>
                                            @foreach($sale->images()->get() as $image)                                  
                                                <a href="{{ $image->url_image }}" class="hidden"></a> 
                                            @endforeach
                                        @endif
                                    </div>                                
                                </div>
                            </div>
                            <!-- Property content -->
                            <div class="property-content">
                                <div class="info">
                                <!-- title -->
                                <h1 class="title">
                                    <a href="{{route('web.buyProperty', ['slug' => $sale->slug])}}">{{$sale->title}}</a>
                                </h1>
                                <!-- Property address -->
                                <h3 class="property-address">
                                    <a href="{{route('web.buyProperty', ['slug' => $sale->slug])}}">
                                        <i class="fa fa-map-marker"></i>{{$sale->neighborhood}} - {{$sale->city}}
                                    </a>
                                </h3>
                                <!-- Facilities List -->
                                <ul class="facilities-list clearfix"> 
                                    @if ($sale->useful_area)
                                        <li>
                                            <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                            <span>{{$sale->useful_area}}{{$sale->measures}}</span>
                                        </li>
                                    @endif
                                    @if ($sale->dormitories)
                                        <li>
                                            <i class="flaticon-bed"></i>
                                            <span>{{$sale->dormitories}} Dorm.</span>
                                        </li>
                                    @endif
                                    @if ($sale->bathrooms)
                                        <li>
                                            <i class="flaticon-holidays"></i>
                                            <span>{{$sale->bathrooms}} Banh.</span>
                                        </li>
                                    @endif
                                    @if ($sale->garage || $sale->covered_garage)
                                        <li>
                                            <i class="flaticon-vehicle"></i>
                                            <span>
                                                @php
                                                if(!empty($sale->garage) && !empty($sale->covered_garage)){
                                                    $g = $sale->garage + $sale->covered_garage;
                                                    echo $g.' Garag.';
                                                }elseif(!empty($sale->garage) && empty($sale->covered_garage)){
                                                    echo $sale->garage.' Garag.';
                                                }else{
                                                    echo $sale->covered_garage.' Garag.';
                                                }
                                                @endphp
                                            </span>
                                        </li>
                                    @endif                            
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>   
                @endforeach
                <a class="button-md button-theme" href="{{route('web.propertyList',['type' => 'venda'])}}" data-hover="Ver mais Imóveis"> Ver mais Imóveis </a>
            </div>        
        </div>
    </div> 
@endif

@if (!empty($propertiesForRent) && $propertiesForRent->count() > 0)
    <div class="properties-section-body content-area">
        <div class="container">
            <!-- TÍTULO  -->
            <div class="main-title">
                <h1>Para Alugar</h1>
            </div>
            <div class="row">   
                @foreach ($propertiesForRent as $rent)             
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp delay-03s">
                        <div class="property" style="min-height: 440px !important;">
                            <!-- Property img -->
                            <div class="property-img">
                                <div class="property-tag button alt featured">Referência: {{$rent->reference}}</div>
                                <div class="property-tag button sale">{{$rent->type}}</div>
                                @if($rent->display_values == 1)
                                    <div class="property-price">R$ {{str_replace(',00', '', $rent->rental_value)}}/{{$rent->getLocationPeriod()}}</div>
                                @endif 
                                <img style="min-height:262px !important;max-height: 262px !important;max-width: 100%;" src="{{--$rent->cover()--}}https://informatica-livre.s3.us-east-2.amazonaws.com/superimoveis/imoveis/5282bcb2-59b0-47ec-9efb-932faba32ea6/444/aluguel-temporada-16867535339626.jpg" alt="{{$rent->title}}" class="img-responsive">
                                <div class="property-overlay">
                                    <a href="{{route('web.buyProperty', ['slug' => $rent->slug])}}" class="overlay-link">
                                        <i class="fa fa-link"></i>
                                    </a>                                       
                                
                                    <div class="property-magnify-gallery"> 
                                        @if($rent->images()->get()->count())
                                            <a href="{{$rent->cover()}}" class="overlay-link"><i class="fa fa-expand"></i></a>
                                            @foreach($rent->images()->get() as $image)                                  
                                                <a href="{{ $image->url_image }}" class="hidden"></a> 
                                            @endforeach
                                        @endif
                                    </div>                                
                                </div>
                            </div>
                            <!-- Property content -->
                            <div class="property-content">
                                <div class="info">
                                <!-- title -->
                                <h1 class="title">
                                    <a href="{{route('web.rentProperty', ['slug' => $rent->slug])}}">{{$rent->title}}</a>
                                </h1>
                                <!-- Property address -->
                                <h3 class="property-address">
                                    <a href="{{route('web.rentProperty', ['slug' => $rent->slug])}}">
                                        <i class="fa fa-map-marker"></i>{{$rent->neighborhood}} - {{$rent->city}}
                                    </a>
                                </h3>
                                <!-- Facilities List -->
                                <ul class="facilities-list clearfix"> 
                                    @if ($rent->useful_area)
                                        <li>
                                            <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                            <span>{{$rent->useful_area}}{{$rent->measures}}</span>
                                        </li>
                                    @endif
                                    @if ($rent->dormitories)
                                        <li>
                                            <i class="flaticon-bed"></i>
                                            <span>{{$rent->dormitories}} Dorm.</span>
                                        </li>
                                    @endif
                                    @if ($rent->bathrooms)
                                        <li>
                                            <i class="flaticon-holidays"></i>
                                            <span>{{$rent->bathrooms}} Banh.</span>
                                        </li>
                                    @endif
                                    @if ($rent->garage || $rent->covered_garage)
                                        <li>
                                            <i class="flaticon-vehicle"></i>
                                            <span>
                                                @php
                                                if(!empty($rent->garage) && !empty($rent->covered_garage)){
                                                    $g = $rent->garage + $rent->covered_garage;
                                                    echo $g.' Garag.';
                                                }elseif(!empty($rent->garage) && empty($rent->covered_garage)){
                                                    echo $rent->garage.' Garag.';
                                                }else{
                                                    echo $rent->covered_garage.' Garag.';
                                                }
                                                @endphp
                                            </span>
                                        </li>
                                    @endif                            
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>   
                @endforeach
                <a class="button-md button-theme" href="{{route('web.propertyList',['type' => 'sale'])}}" data-hover="Ver mais Imóveis"> Ver mais Imóveis </a>
            </div>        
        </div>
    </div> 
@endif

<div class="clearfix"></div>

@if (!empty($experienceCobertura) && $experienceCobertura->count() > 0 
    || !empty($experienceAltoPadrao) && $experienceAltoPadrao->count() > 0 
    || !empty($experienceDeFrenteParaMar) && $experienceDeFrenteParaMar->count() > 0 
    || !empty($experienceCondominioFechado) && $experienceCondominioFechado->count() > 0 
    || !empty($experienceLojasSalas) && $experienceLojasSalas->count() > 0 
    || !empty($experienceCompacto) && $experienceCompacto->count() > 0)
    <!-- Experiências -->
<div class="popular-places content-area-12">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1>Ambiente no seu, <span class="text-front"><b>estilo</b></span></h1>
            <p>Encontre um imóvel com a experiência que você quer viver!</p>            
        </div>
        <div class="row g-0">
            <div class="col-12 wow fadeInLeft delay-04s">
                <div class="row">
                    @if (!empty($experienceCobertura) && $experienceCobertura->count() > 0)
                        <div class="col-md-4 col-sm-12 col-pad">
                            <div class="popular-places-box">
                                <div class="popular-places-overflow">
                                    <div class="popular-places-photo">
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'cobertura']) }}">
                                            <img class="img-fluid w-100" src="{{$experienceCobertura[0]->cover()}}" alt="Cobertura">
                                        </a>
                                    </div>
                                </div>
                                <div class="listings_no">Cobertura ({{$experienceCobertura->count()}})</div>
                                <div class="ling-section">
                                    <h3>
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'cobertura']) }}">Cobertura</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if (!empty($experienceAltoPadrao) && $experienceAltoPadrao->count() > 0)
                        <div class="col-md-4 col-sm-12 col-pad">
                            <div class="popular-places-box">
                                <div class="popular-places-overflow">
                                    <div class="popular-places-photo">
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'alto-padrao']) }}">
                                            <img class="img-fluid w-100" src="{{$experienceAltoPadrao[0]->cover()}}" alt="Alto Padrão">
                                        </a>
                                    </div>
                                </div>
                                <div class="listings_no">Alto Padrão ({{$experienceAltoPadrao->count()}})</div>
                                <div class="ling-section">
                                    <h3>
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'alto-padrao']) }}">Alto Padrão</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                         
                    @if (!empty($experienceDeFrenteParaMar) && $experienceDeFrenteParaMar->count() > 0)
                        <div class="col-md-4 col-sm-12 col-pad">
                            <div class="popular-places-box">
                                <div class="popular-places-overflow">
                                    <div class="popular-places-photo">
                                        <img class="img-fluid w-100" src="{{$experienceDeFrenteParaMar[0]->cover()}}" alt="De frente para o mar">
                                    </div>
                                </div>
                                <div class="listings_no">De frente para o mar ({{$experienceDeFrenteParaMar->count()}})</div>
                                <div class="ling-section">
                                    <h3>
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'de-frente-para-o-mar']) }}">De frente para o mar</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif              
                    
                    @if (!empty($experienceCondominioFechado) && $experienceCondominioFechado->count() > 0)
                        <div class="col-md-4 col-sm-12 col-pad">
                            <div class="popular-places-box">
                                <div class="popular-places-overflow">
                                    <div class="popular-places-photo">
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'condominio-fechado']) }}">
                                            <img class="img-fluid w-100" src="{{$experienceCondominioFechado[0]->cover()}}" alt="Condomínio Fechado">
                                        </a>
                                    </div>
                                </div>
                                <div class="listings_no">Condomínio Fechado ({{$experienceCondominioFechado->count()}})</div>
                                <div class="ling-section">
                                    <h3>
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'condominio-fechado']) }}">Condomínio Fechado</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif  

                    @if (!empty($experienceLojasSalas) && $experienceLojasSalas->count() > 0)
                        <div class="col-md-4 col-sm-12 col-pad">
                            <div class="popular-places-box">
                                <div class="popular-places-overflow">
                                    <div class="popular-places-photo">
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'lojas-e-salas']) }}">
                                            <img class="img-fluid w-100" src="{{$experienceLojasSalas[0]->cover()}}" alt="Lojas e Salas">
                                        </a>
                                    </div>
                                </div>
                                <div class="listings_no">Lojas e Salas ({{$experienceLojasSalas->count()}})</div>
                                <div class="ling-section">
                                    <h3>
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'lojas-e-salas']) }}">Lojas e Salas</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif     

                    @if (!empty($experienceCompacto) && $experienceCompacto->count() > 0)
                        <div class="col-md-4 col-sm-12 col-pad">
                            <div class="popular-places-box">
                                <div class="popular-places-overflow">
                                    <div class="popular-places-photo">
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'compacto']) }}">
                                            <img class="img-fluid w-100" src="{{$experienceCompacto[0]->cover()}}" alt="Compacto">
                                        </a>
                                    </div>
                                </div>
                                <div class="listings_no">Compacto ({{$experienceCompacto->count()}})</div>
                                <div class="ling-section">
                                    <h3>
                                        <a href="{{ route('web.experienceCategory', ['slug' => 'compacto']) }}">Compacto</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif   

                </div>
            </div>            
        </div>
    </div>
</div>
<!-- Experiências end -->
@endif

<div class="clearfix"></div>

@if (!empty($artigos) && $artigos->count() > 0)
    <div class="blog content-area">
        <div class="container">
            <div class="main-title"><h1>Acompanhe nosso Blog</h1></div>
            <div class="row">   
                @foreach ($artigos as $key => $artigo)
                    @if ($key <= 2)
                        <div class="col-lg-4 col-md-4 col-sm-6 wow fadeInLeft delay-04s">
                            <div class="thumbnail blog-box-2 clearfix" style="min-height: 470px;">
                                <div class="blog-photo">
                                    <img src="{{$artigo->cover()}}" alt="{{$artigo->titulo}}" class="img-responsive">                                           
                                </div>
                                <div class="caption detail">
                                    <h4><a href="{{route('web.blog.artigo',['slug' => $artigo->slug])}}">{{$artigo->titulo}}</a></h4>
                                    {{ Words($artigo->content, 26) }}
                                    <div class="clearfix"></div>
                                    <a href="{{route('web.blog.artigo',['slug' => $artigo->slug])}}" class="read-more">Leia +</a>
                                </div>
                            </div>
                        </div>
                    @endif                    
                @endforeach
            </div>
        </div>
    </div>    
@endif

@endsection