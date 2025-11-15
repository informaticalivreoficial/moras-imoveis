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

<livewire:web.property-filter />
<livewire:web.property-list />

@if ($propertiesHighlights && $propertiesHighlights->count() > 0)
    <div class="properties-section-body content-area pt-2 mt-6">
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
                                        @if($property->images->count())
                                            <button 
                                                type="button" 
                                                class="overlay-link open-gallery-btn"
                                                data-images='@json($property->images->pluck("url_image"))'
                                            >
                                                <i class="fa fa-expand"></i>
                                            </button>
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
<div class="pb-4 mt-6 recently-properties chevron-icon">
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
                                            <a href="{{route('web.property',['slug' => $propertyview->slug])}}" class="overlay-link">
                                                <i class="fa fa-link"></i>
                                            </a>
                                            @if($propertyview->images->count())
                                                <button 
                                                    type="button" 
                                                    class="overlay-link open-gallery-btn"
                                                    data-images='@json($propertyview->images->pluck("url_image"))'
                                                >
                                                    <i class="fa fa-expand"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- CONTEUDO -->
                                    <div class="content">
                                        <h4 class="title">
                                            <a href="{{route('web.property',['slug' => $propertyview->slug])}}">{{$propertyview->title}} | {{$propertyview->reference}}</a>
                                        </h4>
                                        @if ($propertyview->neighborhood)
                                            <h3 class="property-address">
                                                <a href="{{route('web.property',['slug' => $propertyview->slug])}}">
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

@php
    $br  = $bairros[0] ?? null;
    $br1 = $bairros[1] ?? null;
    $br2 = $bairros[2] ?? null;
    $br3 = $bairros[3] ?? null;
@endphp

<div class="categories">
    <div class="container">
        <div class="main-title">
            <h1>Locais Populares</h1>
        </div>
        <div class="clearfix"></div>
        <div class="row wow">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="row">
                    @if ($br)
                        <div class="col-sm-6 col-pad wow fadeInLeft delay-04s">
                            <div class="category">
                                <div class="category_bg_box" style="background-image: url('{{ $br->img }}');">
                                    <div class="category-overlay">
                                        <div class="category-content">
                                            <div class="category-subtitle">{{ $br->total }} Imóveis</div>
                                            <h3 class="category-title">
                                                <a href="{{route('web.properties.neighborhood', [ 'neighborhood' => $br->neighborhood ])}}">{{ $br->neighborhood }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if ($br1)
                        <div class="col-sm-6 col-pad wow fadeInLeft delay-04s">
                            <div class="category">
                                <div class="category_bg_box" style="background-image: url('{{ $br1->img }}');">
                                    <div class="category-overlay">
                                        <div class="category-content">
                                            <div class="category-subtitle">{{ $br1->total }} Imóveis</div>
                                            <h3 class="category-title">
                                                <a href="{{route('web.properties.neighborhood', [ 'neighborhood' => $br1->neighborhood ])}}">{{ $br1->neighborhood }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($br2)
                        <div class="col-sm-12 col-pad wow fadeInUp delay-04s">
                            <div class="category">
                                <div class="category_bg_box" style="background-image: url('{{ $br2->img }}');">
                                    <div class="category-overlay">
                                        <div class="category-content">
                                            <div class="category-subtitle">{{ $br2->total }} Imóveis</div>
                                            <h3 class="category-title">
                                                <a href="{{route('web.properties.neighborhood', [ 'neighborhood' => $br2->neighborhood ])}}">{{ $br2->neighborhood }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif                              
                </div>
            </div>
            @if ($br3)
                <div class="col-lg-5 col-md-5 col-sm-12 col-pad wow fadeInRight delay-04s">
                    <div class="category">
                        <div class="category_bg_box category_long_bg" style="background-image: url('{{ $br3->img }}');">
                            <div class="category-overlay">
                                <div class="category-content">
                                    <div class="category-subtitle">{{ $br3->total }} Imóveis</div>
                                    <h3 class="category-title">
                                        <a href="{{route('web.properties.neighborhood', [ 'neighborhood' => $br3->neighborhood ])}}">{{ $br3->neighborhood }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>             
                </div>
            @endif
        </div>
    </div>
</div>  

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
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('galleryRoot', () => ({
                open: false,
                images: [],
                current: 0,
                scale: 1,
                translateX: 0,
                translateY: 0,
                startX: 0,
                startY: 0,
                touchStartX: 0,
                touchEndX: 0,

                init() {
                    // Clique em qualquer botão da galeria
                    document.addEventListener('click', (e) => {
                        const btn = e.target.closest('.open-gallery-btn');
                        if (!btn) return;
                        this.openGallery(btn);
                    });

                    // Teclas
                    document.addEventListener('keydown', (e) => {
                        if (!this.open) return;
                        if (e.key === 'Escape') this.close();
                        if (e.key === 'ArrowRight') this.next();
                        if (e.key === 'ArrowLeft') this.prev();
                    });
                },

                openGallery(btn) {
                    const imgs = JSON.parse(btn.getAttribute('data-images'));
                    if (!imgs?.length) return;
                    this.images = imgs;
                    this.current = 0;
                    this.resetZoom();
                    this.open = true;
                },

                close() {
                    this.open = false;
                    this.resetZoom();
                },

                next() {
                    this.current = (this.current + 1) % this.images.length;
                    this.resetZoom();
                },

                prev() {
                    this.current = (this.current - 1 + this.images.length) % this.images.length;
                    this.resetZoom();
                },

                currentImage() {
                    return this.images[this.current] ?? '';
                },

                toggleZoom() {
                    if (this.scale > 1) {
                        this.resetZoom();
                    } else {
                        this.scale = 2;
                    }
                },

                resetZoom() {
                    this.scale = 1;
                    this.translateX = 0;
                    this.translateY = 0;
                },

                imageStyle() {
                    return `
                        transform: scale(${this.scale}) translate(${this.translateX}px, ${this.translateY}px);
                        transition: transform 0.2s ease-out;
                        cursor: ${this.scale > 1 ? 'move' : 'zoom-in'};
                    `;
                },

                onWheel(e) {
                    if (!this.open) return;
                    e.preventDefault();
                    const delta = e.deltaY < 0 ? 0.2 : -0.2;
                    this.scale = Math.min(Math.max(this.scale + delta, 1), 3);
                },

                onTouchStart(e) {
                    if (e.touches.length === 1) {
                        this.startX = e.touches[0].clientX - this.translateX;
                        this.startY = e.touches[0].clientY - this.translateY;
                        this.touchStartX = e.touches[0].clientX;
                    }
                },

                onTouchMove(e) {
                    if (e.touches.length === 1 && this.scale > 1) {
                        e.preventDefault();
                        this.translateX = e.touches[0].clientX - this.startX;
                        this.translateY = e.touches[0].clientY - this.startY;
                    }
                },

                onTouchEnd(e) {
                    this.touchEndX = e.changedTouches[0].clientX;
                    const diff = this.touchStartX - this.touchEndX;
                    if (Math.abs(diff) > 80 && this.scale === 1) {
                        diff > 0 ? this.next() : this.prev();
                    }
                }
            }));
        });
    </script>
@endsection