<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <meta name="author" content="Renato Montanari"/>
    <meta name="copyright" content="{{env('DESENVOLVEDOR')}}">

    {!! $head ?? '' !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/bootstrap.min.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/animate.min.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/bootstrap-submenu.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/bootstrap-select.min.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/leaflet.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/map.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/fonts/font-awesome/css/font-awesome.min.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/fonts/flaticon/font/flaticon.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/fonts/linearicons/style.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/jquery.mCustomScrollbar.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/dropzone.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/magnific-popup.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/slick.css'))}}">

    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/initial.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/style.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/skins/green-light.css'))}}">

    @hasSection('css')
        @yield('css')
    @endif 

    <link rel="shortcut icon" href="{{$configuracoes->getfaveicon()}}" type="image/x-icon" >

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;900&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/ie8-responsive-file-warning.js'))}}"></script><![endif]-->
    <script src="{{url(asset('frontend/'.$configuracoes->template.'/js/ie-emulation-modes-warning.js'))}}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/html5shiv.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/respond.min.js'))}}"></script>
    <![endif]-->
    @livewireStyles
</head>
<body>

<header class="top-header" id="top">
    <div class="container">
        <div class="row">
            <div class="col-7 col-sm-7 col-md-7 col-lg-6">
                <div class="list-inline">
                    @if ($configuracoes->whatsapp)
                        <a href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->name)}}" class="n-575" title="WhatsApp">
                            <i class="fa fa-whatsapp"></i>{{$configuracoes->whatsapp}}
                        </a>
                    @endif
                    @if ($configuracoes->email)
                        <a href="mailto:{{$configuracoes->email}}" title="Email">
                            <i class="fa fa-envelope"></i>{{$configuracoes->email}}
                        </a>
                    @endif                    
                </div>
            </div>
            <div class="col-5 col-sm-5 col-md-5 col-lg-6">
                <ul class="top-social-media pull-right">
                    <li>
                        <a href="{{route('login')}}" class="sign-in" title="Login"><i class="fa fa-sign-in"></i> Login</a>
                    </li>
                    <!--<li>
                        <a href="signup.html" class="sign-in"><i class="fa fa-user"></i> Register</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </div>
</header>

<header class="main-header  header-shrink ">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{route('home')}}" class="logo" title="{{$configuracoes->name}}">
                <img src="{{$configuracoes->getlogo()}}" alt="{{$configuracoes->name}}">
            </a>
            <button class="navbar-toggler" id="drawer" type="button">
                <span class="fa fa-bars"></span>
            </button>
            <div class="navbar-collapse collapse " id="navbar">
                <ul class="navbar-nav ustify-content-start w-100">
                    <li class="nav-item dropdown">
                        <a title="Imóveis" class="nav-link dropdown-toggle" href="javascript:void(0)" id="imoveisLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Imóveis
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="imoveisLink">
                            <li><a class="dropdown-item" href="{{route('web.propertyList',['type' => 'venda'])}}" title="Comprar">Comprar</a></li>
                            <li><a class="dropdown-item" href="{{route('web.propertyList',['type' => 'locacao'])}}" title="Alugar">Alugar</a></li>
                        </ul>
                    </li> 
                    @if (!empty($categoriasMenu) && $categoriasMenu->count() > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="propriedadesLink" href="javascript:void(0)" title="Propriedades">Propriedades</a>
                            <ul class="dropdown-menu" aria-labelledby="propriedadesLink">
                                @foreach ($categoriasMenu as $catMenu)                                
                                    <li>
                                        <a class="dropdown-item" href="{{route('web.imoveisCategoria',['categoria' => $catMenu->tipo])}}" title="{{$catMenu->tipo}}">{{$catMenu->tipo}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li> 
                    @endif                 
                    
                    @if (!empty($lancamentoMenu) && $lancamentoMenu->count() > 0)
                        <li class="nav-item"><a class="nav-link" href="{{route('web.lancamento')}}" title="Lançamento">Lançamento</a></li>
                    @endif 

                    <li class="nav-item"><a class="nav-link" href="{{route('contact')}}" title="Atendimento">Atendimento</a></li>                    
                    {{--<li class="nav-item"><a class="nav-link" href="{{route('web.financiamento')}}" title="">Financiamento</a></li> --}}                   
                </ul>
            </div>
        </nav>
    </div>
</header>
<!-- Main header end -->

<!-- Sidenav start -->
<nav id="sidebar" class="nav-sidebar">
    <!-- Close btn-->
    <div id="dismiss">
        <i class="fa fa-close"></i>
    </div>
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <img src="{{$configuracoes->getlogo()}}" alt="{{$configuracoes->name}}" title="{{$configuracoes->name}}">
        </div>
        <div class="sidebar-navigation">
            <ul class="menu-list">
                <li>
                    <a class="active pt0" href="javascript:void(0)" title="Imóveis">
                        Imóveis <em class="fa fa-chevron-down"></em>
                    </a>
                    <ul>
                        <li><a href="{{route('web.propertyList',['type' => 'sale'])}}" title="Comprar">Comprar</a></li>
                        <li><a href="{{route('web.propertyList',['type' => 'rent'])}}" title="Alugar">Alugar</a></li>
                    </ul>
                </li>  
                @if (!empty($categoriasMenu) && $categoriasMenu->count() > 0)
                    <li>
                        <a id="propriedadesLink" href="javascript:void(0)" title="Propriedades">
                            Propriedades <em class="fa fa-chevron-down"></em>
                        </a>
                        <ul>
                            @foreach ($categoriasMenu as $catMenu)                                
                                <li>
                                    <a href="{{route('web.imoveisCategoria',['categoria' => $catMenu->tipo])}}" title="{{$catMenu->tipo}}">{{$catMenu->tipo}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li> 
                @endif               
                <li><a href="{{route('web.blog.artigos')}}" title="Dicas">Dicas</a></li>
                <li>
                    <a href="javascript:void(0)" title="Páginas">Páginas <em class="fa fa-chevron-down"></em></a>
                    <ul>  
                        @if (!empty($paginaMenu) && $paginaMenu->count() > 0)
                            @foreach($paginaMenu as $paginaM)
                                <li><a title="{{$paginaM->titulo}}" href="{{route('web.pagina', [ 'slug' => $paginaM->slug ])}}">{{$paginaM->titulo}}</a></li>
                            @endforeach
                        @endif
                        <li>
                            <a href="{{route('web.pesquisar-imoveis')}}" title="Pesquisar Imóveis">Pesquisar Imóveis</a>
                        </li>
                        <li>
                            <a href="{{route('web.politica')}}" title="Política de Privacidade">Política de Privacidade</a>
                        </li>                     
                    </ul>
                </li>
                @if (!empty($lancamentoMenu) && $lancamentoMenu->count() > 0)
                    <li><a class="nav-link" href="{{route('web.lancamento')}}" title="Lançamento">Lançamento</a></li>
                @endif 
                <li><a href="{{route('contact')}}" title="Atendimento">Atendimento</a></li>
               
               {{-- <li>
                    <a href="submit-property.html">Submit Property</a>
                </li>--}}
            </ul>
        </div>
        <div class="get-in-touch">
            <h3 class="heading">Fale Conosco</h3>
            @if ($configuracoes->telefone)
                <div class="sidebar-contact-info">
                    <div class="icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="body-info">
                        <a href="tel:{{$configuracoes->telefone}}" title="Telefone">{{$configuracoes->telefone}} </a>
                    </div>
                </div>
            @endif
            @if ($configuracoes->whatsapp)
                <div class="sidebar-contact-info">
                    <div class="icon">
                        <i class="fa fa-whatsapp"></i>
                    </div>
                    <div class="body-info">
                        <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->name)}}" title="WhatsApp">{{$configuracoes->whatsapp}}</a>
                    </div>
                </div>
            @endif
            @if ($configuracoes->email)
                <div class="sidebar-contact-info">
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="body-info">
                        <a href="mailto:{{$configuracoes->email}}" title="Email">{{$configuracoes->email}}</a>
                    </div>
                </div>
            @endif
            @if ($configuracoes->email1)
                <div class="sidebar-contact-info">
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="body-info">
                        <a href="mailto:{{$configuracoes->email1}}" title="Email">{{$configuracoes->email1}}</a>
                    </div>
                </div>
            @endif
        </div>
        <div class="get-social">
            <h3 class="heading">Redes Sociais</h3>
            @if ($configuracoes->facebook)
                <a target="_blank" class="facebook-bg" href="{{$configuracoes->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a>
            @endif
            @if ($configuracoes->twitter)
                <a target="_blank" class="twitter-bg" href="{{$configuracoes->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a>
            @endif
            @if ($configuracoes->instagram)
                <a target="_blank" class="instagram-bg" href="{{$configuracoes->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a>
            @endif
            @if ($configuracoes->linkedin)
                <a target="_blank" class="linkedin-bg" href="{{$configuracoes->linkedin}}" title="Linkedin"></a><i class="fa fa-linkedin"></i>
            @endif
            @if ($configuracoes->youtube)
                <a target="_blank" class="youtube-bg" href="{{$configuracoes->youtube}}" title="Youtube"><i class="fa fa-youtube"></i></a>
            @endif
        </div>
    </div>
</nav>
<!-- Sidenav end -->

    {{ $slot }}
    {{--@yield('content')--}}


<!-- Intro section start -->
<div class="intro-section">
    <div class="intro-section-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-7 col-sm-12">
                    <h3>Quer vender ou alugar seu imóvel?</h3>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-12">
                    <a class="btn-2 btn-white" href="{{route('contact')}}" title="Quer vender ou alugar seu imóvel?">
                        <span>Entrar em contato</span> <i class="arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Intro section end -->

<footer class="main-footer clearfix">
    <div class="container">
        <!-- Footer info-->
        <div class="footer-info">
            <div class="row">
                <!-- About us -->
                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
                    <div class="footer-item fi2">
                        <div class="main-title-2">
                            <h1>Atendimento</h1>
                            <p>{{$configuracoes->information}}</p>
                        </div>
                        <ul class="personal-info">
                            @if ($configuracoes->street)
                                <li>
                                    <i class="fa fa-map-marker"></i>
                                    {{$configuracoes->street}}
                                    {{($configuracoes->number ? ', '.$configuracoes->number : '')}}  
                                    {!!($configuracoes->neighborhood ? '<br> '.$configuracoes->neighborhood : '')!!}  
                                    {{($configuracoes->city ? ', '.$configuracoes->city : '')}} 
                                </li> 
                            @endif
                            @if ($configuracoes->email)
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:{{$configuracoes->email}}" title="Email">{{$configuracoes->email}}</a>
                                </li>
                            @endif
                            @if ($configuracoes->additional_email)
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:{{$configuracoes->additional_email}}" title="Email">{{$configuracoes->additional_email}}</a>
                                </li>
                            @endif
                            @if ($configuracoes->phone)
                                <li>
                                    <i class="fa fa-phone"></i>
                                    <a href="tel:{{$configuracoes->phone}}" title="Telefone">{{$configuracoes->phone}}</a>
                                    @if ($configuracoes->cell_phone)
                                        <a href="tel:{{$configuracoes->cell_phone}}" title="Telefone Móvel"> {{$configuracoes->cell_phone}}</a>
                                    @endif
                                </li>
                            @endif                            
                            @if ($configuracoes->whatsapp)
                                <li>
                                    <i class="fa fa-whatsapp"></i>
                                    <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->app_name)}}" title="WhatsApp">{{$configuracoes->whatsapp}}</a>
                                </li>
                            @endif                            
                        </ul>
                    </div>
                </div>
                <!-- Links -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="footer-item">
                        <div class="main-title-2">
                            <h1>Links</h1>
                        </div>
                        <ul class="links">
                            @if (!empty($paginaMenu) && $paginaMenu->count() > 0)
                                @foreach($paginaMenu as $paginaM)
                                    <li><a title="{{$paginaM->titulo}}" href="{{route('web.pagina', [ 'slug' => $paginaM->slug ])}}">{{$paginaM->titulo}}</a></li>
                                @endforeach
                            @endif
                            <li>
                                <a href="{{route('web.blog.artigos')}}" title="Dicas">Dicas</a>
                            </li>
                            <li>
                                <a href="{{route('web.noticias')}}" title="Notícias">Notícias</a>
                            </li>
                            <li>
                                <a href="{{route('web.pesquisar-imoveis')}}" title="Pesquisar Imóveis">Pesquisar Imóveis</a>
                            </li>
                            <li>
                                <a href="{{route('contact')}}" title="Atendimento">Atendimento</a>
                            </li>
                            <li>
                                <a href="{{route('web.politica')}}" title="Política de Privacidade">Política de Privacidade</a>
                            </li>
                        </ul>
                    </div>
                </div>
               
                {{--
                <!-- Subscribe -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    @if (!empty($newsletterForm))
                        <div class="footer-item">
                            <div class="main-title-2">
                                <h1>Inscreva-se</h1>
                            </div>
                            <div class="newsletter clearfix">
                                <p>Receba direto no seu e-mail, nossas dicas e novidades sobre compra, venda e locação de imóveis!</p>
                                <form class="form-inline j_submitnewsletter" action="" method="POST">
                                    @csrf                                
                                    <div id="js-newsletter-result"></div>
                                    <div class="row form_hide">
                                        <div class="col-12">
                                            <!-- HONEYPOT -->
                                            <input type="hidden" class="noclear" name="bairro" value="" />
                                            <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                            <input type="hidden" class="noclear" name="status" value="1" />
                                            <input type="hidden" class="noclear" name="nome" value="#Cadastrado pelo Site" />
                                            <input class="form-control" type="email" name="email" placeholder="Seu email...">
                                            <button class="btn button-theme" type="submit"><i class="fa fa-paper-plane"></i></button>
                                        </div>
                                    </div>                                
                                </form>
                            </div>
                        </div>
                    @endif                    
                </div>
                --}}
            </div>
        </div>
    </div>
    <div class="copy-right">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <p style="font-size: 14px;">&copy;  {{$configuracoes->init_date}} {{$configuracoes->app_name}}. Todos os direitos reservados.</p>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <ul class="social-list clearfix">
                        @if ($configuracoes->facebook)
                            <li><a target="_blank" class="facebook-bg" href="{{$configuracoes->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        @endif
                        @if ($configuracoes->twitter)
                            <li><a target="_blank" class="twitter-bg" href="{{$configuracoes->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if ($configuracoes->instagram)
                            <li><a target="_blank" class="instagram-bg" href="{{$configuracoes->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                        @endif
                        @if ($configuracoes->linkedin)
                            <li><a target="_blank" class="linkedin-bg" href="{{$configuracoes->linkedin}}" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                        @endif
                        @if ($configuracoes->youtube)
                            <li><a target="_blank" class="youtube-bg" href="{{$configuracoes->youtube}}" title="Youtube"><i class="fa fa-youtube"></i></a></li>
                        @endif 
                    </ul>
                </div>
                <div class="col-12 text-center my-3">
                    <span class="small text-silver-dark">Feito com <i style="color:red;" class="fa fa-heart"></i> por <a style="color:#fff;" target="_blank" href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a></span>					
                </div>
            </div>
        </div>
    </div>
</footer>


<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.min.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/bootstrap.bundle.min.js'))}}"></script>
<script  src="{{url(asset('frontend/'.$configuracoes->template.'/js/bootstrap-submenu.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/rangeslider.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.mb.YTPlayer.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/wow.min.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/bootstrap-select.min.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.easing.1.3.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.scrollUp.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.mCustomScrollbar.concat.min.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/leaflet.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/leaflet-providers.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/leaflet.markercluster.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/dropzone.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.filterizr.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.magnific-popup.min.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/slick.min.js'))}}"></script>
<script src="{{--url(asset('frontend/'.$configuracoes->template.'/js/maps.js'))--}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/sidebar.js'))}}"></script>
<script src="{{url(asset('frontend/'.$configuracoes->template.'/js/app.js'))}}"></script>

@vite('resources/js/app.js')

@hasSection('js')
    @yield('js')
@endif

<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_submitnewsletter').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.sendNewsletter') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-subscribe-btn").attr("disabled", true);
                    //form.find('#js-subscribe-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(response){
                    $('html, body').animate({scrollTop:$('#js-newsletter-result').offset().top-40}, 'slow');
                    if(response.error){
                        form.find('#js-newsletter-result').html('<div class="alert alert-danger error-msg">'+ response.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-newsletter-result').html('<div class="alert alert-success error-msg">'+ response.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(response){
                    form.find("#js-subscribe-btn").attr("disabled", false);
                    //form.find('#js-subscribe-btn').html("Cadastrar!");                                
                }

            });

            return false;
        });

    });
</script>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{$configuracoes->analytics_id}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', "{{$configuracoes->analytics_id}}");
</script>

    @livewireScripts
</body>
</html>