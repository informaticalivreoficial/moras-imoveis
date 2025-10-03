@extends("web.$configuracoes->template.master.master")

@section('content')

@if ($slides && $slides->count())
    <!-- Banner start -->
    <div class="banner">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @foreach ($slides as $key => $slide)
                    <div class="item banner-max-height {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ $slide->getimagem() }}" alt="{{ $slide->titulo }}">
                        <div class="carousel-caption banner-slider-inner">
                            <div class="banner-content">                

                                {{-- título opcional --}}
                                @if ($slide->view_title)
                                    <h1 data-animation="animated fadeInDown delay-05s">{{ $slide->titulo }}</h1>
                                @endif 

                                {{-- conteúdo opcional --}}
                                @if ($slide->content)
                                    <p data-animation="animated fadeInUp delay-1s">{{ $slide->content }}</p>
                                @endif

                                {{-- botão/link --}}
                                <a 
                                    href="{{ $slide->link ?: '#' }}" 
                                    title="{{ $slide->titulo }}" 
                                    class="btn button-md button-theme" 
                                    @if ($slide->target == 1) target="_blank" @endif
                                    data-animation="animated fadeInUp delay-15s"
                                >
                                    Clique aqui!
                                </a> 
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
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="slider-mover-right" aria-hidden="true">
                    <i class="fa fa-angle-right"></i>
                </span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <!-- Banner end -->
@endif

@if ($propertiesHighlights && $propertiesHighlights->count() > 0)
    <div class="properties-section-body content-area">
        <div class="container">
            <div class="main-title">
                <h1>Destaque</h1>
                <div class="row">
                    @foreach ($propertiesHighlights as $property)
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp delay-03s">
                            <div class="property" style="min-height: 420px !important;">
                                <!-- Property img -->
                                <div class="property-img">
                                    <div class="property-tag button alt featured">Referência: {{$property->reference}}</div>                                    
                                    <div 
                                    class="property-tag button sale d-inline-block bg-success text-white" 
                                    style="right: 15px;bottom: 45px;"
                                    >
                                        @if($property->sale && $property->location)
                                            Vende / Aluga
                                        @elseif($property->sale)
                                            Vende
                                        @elseif($property->location)
                                            Aluga
                                        @endif
                                    </div>                                    
                                    @if ($property->sale_value)
                                        <div class="property-price" style="text-align: left;">                                            
                                            @php
                                                $venda = ($property->sale_value && !empty($property->sale_value))
                                                    ? 'R$' . number_format($property->sale_value, 0, ',', '.')
                                                    : null;

                                                $aluguel = ($property->rental_value && !empty($property->rental_value))
                                                    ? 'R$' . number_format($property->rental_value, 0, ',', '.') . '/'. $property->getLocationPeriod()
                                                    : null;
                                            @endphp

                                            @if($venda && $aluguel)
                                                Venda: {{ $venda }} <br> Locação: {{ $aluguel }}
                                            @elseif($venda)
                                                Venda: {{ $venda }}
                                            @elseif($aluguel)
                                                Locação: {{ $aluguel }}
                                            @else
                                                Sob Consulta
                                            @endif                                            
                                        </div>
                                    @endif
                                    
                                    <img style="min-height: 240px !important;" src="{{$property->cover()}}" alt="{{$property->title}}" class="img-responsive"/>
                                                       
                                    <div class="property-overlay">
                                        <a href="{{route('web.property',['$property->slug'])}}" class="overlay-link">
                                            <i class="fa fa-link"></i>
                                        </a>
                                        @if($property->images()->get()->count())
                                            <a href="{{$property->cover()}}" class="overlay-link"><i class="fa fa-expand"></i></a>
                                            <div class="property-magnify-gallery"> 
                                                @foreach($property->images()->get() as $image)                                  
                                                    <a href="{{ $image->url_image }}" class="hidden"></a> 
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Property content -->
                                <div class="property-content">
                                    <!-- title -->
                                    <h1 class="title">
                                        <a href="{{route('web.property',['$property->slug'])}}">{{$property->title}}</a>                                        
                                    </h1>
                                    <!-- Property address -->
                                    @if ($property->neighborhood)
                                        <h3 class="property-address">
                                            <a href="{{route('web.property',['$property->slug'])}}">
                                                <i class="fa fa-map-marker"></i> {{$property->neighborhood}}, {{$property->city}} / {{$property->state}}
                                            </a>
                                        </h3>                                        
                                    @endif                                    
                                    <!-- Facilities List -->
                                    <ul class="facilities-list clearfix" style="text-align: left;">
                                        @if ($property->total_area)
                                            <li>
                                                <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                                <span>{{$property->total_area}} {{$property->measures}}</span>
                                            </li>                                            
                                        @endif
                                        @if ($property->dormitories)
                                            <li>
                                                <i class="flaticon-bed"></i>
                                                <span>{{$property->dormitories}} Dorm.</span>
                                            </li>                                            
                                        @endif
                                        @if ($property->bathrooms)
                                            <li>
                                                <i class="flaticon-holidays"></i>
                                                <span>{{$property->bathrooms}} Banh.</span>
                                            </li>                                            
                                        @endif
                                        @if ($property->garage)
                                            <li>
                                                <i class="flaticon-vehicle"></i>
                                                <span>{{$property->garage}} Garag.</span>
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
    </div>
@endif  

@if ($propertiesViews && $propertiesViews->count() > 0)
<!-- IMOVEIS MAIS VISUALIZADOS INICIO -->
<div class="mb-70 recently-properties chevron-icon">
    <div class="container">
        <!-- MAIN TITULO -->
        <div class="main-title">
            <h1>Mais Visualizados</h1>
        </div>
        <div class="row">
            <div class="carousel our-partners slide" id="ourPartners2">
                <div class="col-lg-12 mrg-btm-30">
                    <a class="right carousel-control" href="#ourPartners2" data-slide="prev"><i class="fa fa-chevron-left icon-prev"></i></a>
                    <a class="right carousel-control" href="#ourPartners2" data-slide="next"><i class="fa fa-chevron-right icon-next"></i></a>
                </div>
                <div class="carousel-inner">
                    @foreach ($propertiesViews as $key => $propertyview)
                        <div class="item {{$key == 0 ? 'active' : ''}}">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                
                                <div class="property-2" style="min-height: 350px !important;">
                                    
                                    <div class="property-img">
                                        
                                        <div class="price-ratings">
                                            <div class="price" style="text-align: left;">
                                               @if($propertyview->display_values)
                                                    @php
                                                        $venda = ($propertyview->sale_value && !empty($propertyview->sale_value))
                                                            ? 'R$' . number_format($propertyview->sale_value, 0, ',', '.')
                                                            : null;

                                                        $aluguel = ($propertyview->rental_value && !empty($propertyview->rental_value))
                                                            ? 'R$' . number_format($propertyview->rental_value, 0, ',', '.') . '/'. $propertyview->getLocationPeriod()
                                                            : null;
                                                    @endphp

                                                    @if($venda && $aluguel)
                                                        Venda: {{ $venda }} <br> Locação: {{ $aluguel }}
                                                    @elseif($venda)
                                                        Venda: {{ $venda }}
                                                    @elseif($aluguel)
                                                        Locação: {{ $aluguel }}
                                                    @else
                                                        Sob Consulta
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="ratings">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa {{ $i <= $propertyview->stars ? 'fa-star' : 'fa-star-o' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <img style="min-height: 175px !important;" src="{{$propertyview->cover()}}" alt="{{$propertyview->title}}" class="img-responsive"/>
                                        
                                        <div class="property-overlay">
                                            <a href="{{route('web.property',['$propertyview->slug'])}}" class="overlay-link">
                                                <i class="fa fa-link"></i>
                                            </a>
                                            @if($propertyview->images()->get()->count())
                                                <a href="{{$propertyview->cover()}}" class="overlay-link"><i class="fa fa-expand"></i></a>
                                                <div class="property-magnify-gallery"> 
                                                    @foreach($propertyview->images()->get() as $image)                                  
                                                        <a href="{{ $image->url_image }}" class="hidden"></a> 
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- CONTEUDO -->
                                    <div class="content">
                                        <h4 class="title">
                                            <a href="{{route('web.property',['$propertyview->slug'])}}">{{$propertyview->title}} | {{$propertyview->reference}}</a>
                                        </h4>
                                        @if ($propertyview->neighborhood)
                                            <h3 class="property-address">
                                                <a href="{{route('web.property',['$propertyview->slug'])}}">
                                                    <i class="fa fa-map-marker"></i> {{$propertyview->neighborhood}}, {{$propertyview->city}} / {{$propertyview->state}}
                                                </a>
                                            </h3>                                        
                                        @endif 
                                    </div>
                                    
                                    <ul class="facilities-list clearfix">
                                        @if ($propertyview->total_area)
                                            <li>
                                                <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                                <span>{{$propertyview->total_area}} {{$propertyview->measures}}</span>
                                            </li>                                            
                                        @endif
                                        @if ($propertyview->dormitories)
                                            <li>
                                                <i class="flaticon-bed"></i>
                                                <span>{{$propertyview->dormitories}}</span>
                                            </li>                                            
                                        @endif
                                        @if ($propertyview->bathrooms)
                                            <li>
                                                <i class="flaticon-holidays"></i>
                                                <span>{{$propertyview->bathrooms}}</span>
                                            </li>                                            
                                        @endif
                                        @if ($propertyview->garage)
                                            <li>
                                                <i class="flaticon-vehicle"></i>
                                                <span>{{$propertyview->garage}}</span>
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
    </div>
</div>
<!-- IMOVEIS MAIS VISUALIZADOS FIM -->    
@endif

<div class="clearfix"></div>

@if ($artigos && $artigos->count() > 0)
    <div class="blog content-area">
        <div class="container">
            <div class="main-title"><h1>Acompanhe nosso Blog</h1></div>
            <div class="row">   
            @foreach($artigos as $blog)
                <div class="col-lg-4 col-md-4 col-sm-6 wow fadeInLeft delay-04s">
                    <div class="thumbnail blog-box-2 clearfix" style="min-height: 470px;">
                        <div class="blog-photo">
                            <img src="{{$blog->cover()}}" alt="{{$blog->title}}" class="img-responsive">                
                        </div>
                        <div class="caption detail">
                            @php
                                $tipo = $blog->type == 'noticia' ? 'noticia' : 'artigo';
                            @endphp
                            <h4><a href="{{route('web.blog.'.$tipo.'',['slug' => $blog->slug])}}">{{$blog->title}}</a></h4>
                            {!!$blog->content_web!!}
                            <div class="clearfix"></div>
                            <a href="{{route('web.blog.'.$tipo.'',['slug' => $blog->slug])}}" class="read-more">Leia +</a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>    
@endif

@endsection

@section('css')
    <style>
        .stars-outer {
            position: relative;
            display: inline-block;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #ccc; /* cor das estrelas vazias */
        }
        .stars-inner {
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
            color: #f8ce0b; /* cor das estrelas cheias */
        }
        .stars-outer::before {
            content: "\f005\f005\f005\f005\f005"; /* 5 estrelas vazias */
        }
        .stars-inner::before {
            content: "\f005\f005\f005\f005\f005"; /* 5 estrelas cheias */
        }
    </style>
@endsection

@section('js')
    <script src="{{asset('frontend/'.$configuracoes->template.'/js/jquery.magnific-popup.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.overlay-link').on('click', function(e) {
                e.preventDefault(); // evita o comportamento padrão do link

                // seleciona o container de imagens ocultas
                const $gallery = $(this).siblings('.property-magnify-gallery');

                // inicializa o Magnific Popup
                $gallery.magnificPopup({
                    delegate: 'a',        // todos os <a> dentro do container
                    type: 'image',
                    gallery: { enabled: true }
                }).magnificPopup('open', 0); // abre a partir do primeiro link
            });
        });
    </script>
@endsection