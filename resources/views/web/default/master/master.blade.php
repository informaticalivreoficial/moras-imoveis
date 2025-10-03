<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta name="language" content="pt-br" />  
        <meta name="copyright" content="{{$configuracoes->init_date}} - {{$configuracoes->app_name}}"> 
        
        <meta name="author" content="{{env('DESENVOLVEDOR')}}"/>
        <meta name="designer" content="Renato Montanari">
        <meta name="publisher" content="Renato Montanari">
        <meta name="url" content="{{$configuracoes->domain}}" />
        <meta name="keywords" content="{{$configuracoes->metatags}}">
        <meta name="distribution" content="web">
        <meta name="rating" content="general">
        <meta name="date" content="December 2018">      

        {!! $head ?? '' !!}        
                
        <!-- FAVICON -->
        <link rel="icon" type="image/png" href="{{$configuracoes->getfaveicon()}}" />
        <link rel="shortcut icon" href="{{$configuracoes->getfaveicon()}}" type="image/x-icon"/>  
        
        <!-- CSS -->
        
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/bootstrap.min.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/animate.min.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/bootstrap-submenu.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/bootstrap-select.min.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/leaflet.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/map.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/fonts/font-awesome/css/font-awesome.min.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/fonts/flaticon/font/flaticon.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/fonts/linearicons/style.css'))}}"/>
        <link rel="stylesheet" type="text/css"  href="{{url(asset('frontend/'.$configuracoes->template.'/css/jquery.mCustomScrollbar.css'))}}"/>
        <link rel="stylesheet" type="text/css"  href="{{url(asset('frontend/'.$configuracoes->template.'/css/dropzone.css'))}}"/>
        <link rel="stylesheet" type="text/css"  href="{{url(asset('frontend/'.$configuracoes->template.'/css/magnific-popup.css'))}}"/>

        <!-- Custom stylesheet -->
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/style.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/renato.css'))}}"/>
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/css/skins/green-light.css'))}}"/>

        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/js/jsSocials/jssocials.css'))}}" />
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/js/jsSocials/jssocials-theme-flat.css'))}}" />
        <link rel="stylesheet" type="text/css" href="{{url(asset('frontend/'.$configuracoes->template.'/js/shadowbox/shadowbox.css'))}}"/>
        <!-- Google fonts -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">  
        
        @hasSection('css')
            @yield('css')
        @endif    

    </head>
    <body>
        <!-- Top header start -->
        <header class="top-header hidden-xs" id="top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="list-inline">
                            @if ($configuracoes->cell_phone)
                                <a href="tel:{{$configuracoes->cell_phone}}"><i class="fa fa-phone"></i>{{$configuracoes->cell_phone}}</a>
                            @endif
                            @if ($configuracoes->whatsapp)
                                <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->name)}}"><i class="fa fa-whatsapp"></i>{{$configuracoes->whatsapp}}</a>
                            @endif
                            @if ($configuracoes->email)
                                <a href="mailto:{{$configuracoes->email}}"><i class="fa fa-envelope"></i>{{$configuracoes->email}}</a>                                
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="text-align: right;">
                        <a target="_blank" style="margin-top: 5px;margin-bottom: 5px;" href="//BASE.'/pagina/simulador';?>" class="btn button-sm border-button-theme">financiamento</a>
                        <a style="margin-top: 5px;margin-bottom: 5px;margin-left: 10px;" href="//BASE.'/imoveis/busca-por-referencia';?>" class="btn button-sm border-button-theme">Busca por referência</a>
                                               
                        <ul class="top-social-media pull-right" style="margin-left: 10px;">
                            @if ($configuracoes->facebook)
                                <li><a target="_blank" href="{{$configuracoes->facebook}}" class="facebook"><i class="fa fa-facebook"></i></a></li>                                
                            @endif
                            @if ($configuracoes->twitter)
                                <li><a target="_blank" href="{{$configuracoes->twitter}}" class="twitter"><i class="fa fa-twitter"></i></a></li>
                            @endif
                            @if ($configuracoes->linkedin)
                                <li><a target="_blank" href="{{$configuracoes->linkedin}}" class="linkedin"><i class="fa fa-linkedin"></i></a></li>                                
                            @endif
                            @if ($configuracoes->instagram)
                                <li><a target="_blank" href="{{$configuracoes->instagram}}" class="instagram"><i class="fa fa-instagram"></i></a></li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </header>
    <!-- Top header end -->

    <!-- Main header start -->
    <header class="main-header">
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="navbar-header">                
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navigation" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="{{route('web.home')}}" class="logo" title="{{$configuracoes->app_name}}">
                        <img src="{{$configuracoes->getlogo()}}" alt="{{$configuracoes->app_name}}"/>
                    </a>
                    <ul class="top-social-media mobile">
                        @if ($configuracoes->facebook)
                            <li><a target="_blank" href="{{$configuracoes->facebook}}" class="facebook"><i class="fa fa-facebook"></i></a></li>                                
                        @endif
                        @if ($configuracoes->twitter)
                            <li><a target="_blank" href="{{$configuracoes->twitter}}" class="twitter"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if ($configuracoes->linkedin)
                            <li><a target="_blank" href="{{$configuracoes->linkedin}}" class="linkedin"><i class="fa fa-linkedin"></i></a></li>                                
                        @endif
                        @if ($configuracoes->instagram)
                            <li><a target="_blank" href="{{$configuracoes->instagram}}" class="instagram"><i class="fa fa-instagram"></i></a></li>
                        @endif
                    </ul>
                </div>
                <!-- MENU -->
                <div class="navbar-collapse collapse" role="navigation" aria-expanded="true" id="app-navigation">
                    <ul class="nav navbar-nav">
                        @if (!empty($Links) && $Links->count())                            
                            @foreach($Links as $menuItem)  

                            <li {{($menuItem->children && $menuItem->parent ? 'class=dropdown' : '')}}>
                                <a 
                                    {{($menuItem->target == 1 ? 'target=_blank' : 'target=_self')}} 
                                    target="_self" 
                                    href="{{($menuItem->type == 'Página' ? route('web.pagina', [ 'slug' => ($menuItem->post != null ? $menuItem->PostObject->slug : '#') ]) : $menuItem->url)}}">
                                    {{ $menuItem->title }}{!!($menuItem->children && $menuItem->parent ? "<span class=\"caret\"></span>" : '')!!}
                                </a>
                                @if( $menuItem->children && $menuItem->parent)
                                    <ul class="dropdown-menu">
                                        @foreach($menuItem->children as $subMenuItem)
                                        <li class="dropdown-submenu">
                                            <a {{($subMenuItem->target == 1 ? 'target=_blank' : 'target=_self')}} href="{{($subMenuItem->tipo == 'Página' ? route('web.pagina', [ 'slug' => ($subMenuItem->post != null ? $subMenuItem->PostObject->slug : '#') ]) : $subMenuItem->url)}}">{{ $subMenuItem->titulo }}</a>
                                        </li>                                        
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                            @endforeach
                        @endif
                        <li><a href="https://imobiliariaubatuba.com/pagina/atendimento">Atendimento</a></li>                        
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right rightside-navbar">
                        <li>
                            <a href="" class="button">
                                Cadastre seu Imóvel
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- Main header end -->    

    @yield('content')

    <!-- Footer start -->
    <footer class="main-footer clearfix">
        <div class="container">
            <!-- Footer info-->
            <div class="footer-info">
                <div class="row">
                    <!-- About us -->
                    <div class="col-lg-5 col-md-3 col-sm-6 col-xs-12">
                        <div class="footer-item">
                            <div class="main-title-2">
                                <h1>Atendimento</h1>
                            </div>
                            {{$configuracoes->information}}
                            <ul class="personal-info"><br />                                 
                                @if ($configuracoes->display_address)
                                    <li>
                                        <i class="fa fa-map-marker"></i>
                                        @if ($configuracoes->street)
                                            {{$configuracoes->street}}                                            
                                        @endif
                                        @if ($configuracoes->number)
                                            , {{$configuracoes->number}}                                            
                                        @endif
                                        @if ($configuracoes->neighborhood)
                                            , {{$configuracoes->neighborhood}}                                            
                                        @endif
                                        @if ($configuracoes->city)
                                            - {{$configuracoes->city}}                                            
                                        @endif
                                        @if ($configuracoes->state)
                                            / {{$configuracoes->state}}
                                        @endif
                                    </li>
                                @endif  
                                @if ($configuracoes->email)
                                    <li>
                                        <i class="fa fa-envelope"></i>
                                        Telefone: <a href="mailto::{{$configuracoes->email}}">{{$configuracoes->email}}</a>
                                    </li>                                    
                                @endif 
                                @if ($configuracoes->additional_email)
                                    <li>
                                        <i class="fa fa-envelope"></i>
                                        Telefone: <a href="mailto::{{$configuracoes->additional_email}}">{{$configuracoes->additional_email}}</a>
                                    </li>                                    
                                @endif 
                                @if ($configuracoes->phone)
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        Telefone: <a href="tel:{{$configuracoes->phone}}">{{$configuracoes->phone}}</a>
                                    </li>                                    
                                @endif                                
                                @if ($configuracoes->cell_phone)
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        Telefone: <a href="tel:{{$configuracoes->cell_phone}}">{{$configuracoes->cell_phone}}</a>
                                    </li>                                    
                                @endif  
                                @if ($configuracoes->whatsapp)
                                    <li>
                                        <i class="fa fa-whatsapp"></i>
                                        WhatsApp: <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->app_name)}}">{{$configuracoes->whatsapp}}</a>
                                    </li>                                    
                                @endif                 
                            </ul>
                        </div>
                    </div>
                    <!-- Links -->
                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                        <div class="footer-item">
                            <div class="main-title-2">
                                <h1>Links</h1>
                            </div>
                            <ul class="links">
                                <li><a href="{{route('web.home')}}">Início </a></li>
                                <li><a href="/blog/artigos">Blog</a></li>
                                <li><a href="/imoveis/index">Imóveis</a></li>
                                <li><a target="_blank" href="/pagina/simulador">Financiamento</a></li>
                                <li><a href="/imoveis/busca-por-referencia">Busca</a></li>
                                <li><a href="/imoveis/cadastrar">Cadastrar Imóvel</a></li>
                                <li><a href="/pagina/atendimento">Atendimento</a></li>                            
                            </ul>
                        </div>
                    </div>
                    <!-- Recent cars -->
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="footer-item popular-posts">
                            <div class="main-title-2">
                                <h1>Blog</h1>
                            </div>                            
                            @if($artigos && $artigos->count())
                                @foreach($artigos as $blog)
                                    <div class="media">
                                        <div class="media-left">
                                            <img width="90" class="media-object" src="{{$blog->cover()}}" alt="{{$blog->title}}">                                    
                                        </div>
                                        <div class="media-body">
                                            <h3 class="media-heading">
                                                <a href="'.BASE.'/blog/artigo/'.$blog['url'].'">{{$blog->title}}</a>
                                            </h3>
                                            <p>{{ $blog->created_at->format('d M, Y') }}</p>                                    
                                        </div>
                                    </div>
                                @endforeach
                            @endif                            
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer end -->

    <!-- Copy right start -->
    <div class="copy-right">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-8 col-sm-12">
                    &copy;  {{$configuracoes->init_date}} {{$configuracoes->app_name}} - Todos os direitos reservados.
                </div>
                <div class="col-md-4 col-sm-12">
                    <ul class="social-list clearfix">
                        <?php
                            // if(FACEBOOK):
                            // echo '<li><a target="_blank" href="'.FACEBOOK.'" class="facebook"><i class="fa fa-facebook"></i></a></li>';
                            // endif;
                            // if(TWITTER):
                            //     echo '<li><a target="_blank" href="'.TWITTER.'" class="twitter"><i class="fa fa-twitter"></i></a></li>';
                            // endif;
                            // if(LINKEDIN):
                            //     echo '<li><a target="_blank" href="'.LINKEDIN.'" class="linkedin"><i class="fa fa-linkedin"></i></a></li>';
                            // endif;
                            // if(GOOGLE):
                            //     echo '<li><a target="_blank" href="'.GOOGLE.'" class="google"><i class="fa fa-google-plus"></i></a></li>';
                            // endif;
                            // if(INSTAGRAN):
                            //     echo '<li><a target="_blank" href="'.INSTAGRAN.'" class="instagram"><i class="fa fa-instagram"></i></a></li>';
                            // endif;
                        ?>
                    </ul>
                    <span class="small text-silver-dark">Feito com <i style="color:red;" class="fa fa-heart"></i> por <a style="color:#fff;" target="_blank" href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a></span>                    
                </div>
            </div>
        </div>
    </div>
    <!-- Copy end right-->   

    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery-2.2.0.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.form.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/bootstrap.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/bootstrap-submenu.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/rangeslider.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.mb.YTPlayer.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/wow.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/bootstrap-select.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.easing.1.3.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.scrollUp.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.mCustomScrollbar.concat.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/leaflet.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/leaflet-providers.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/leaflet.markercluster.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/dropzone.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.filterizr.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/maps.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/app.js'))}}"></script>


    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jsSocials/jssocials.min.js'))}}"></script>

    <!-- Máscara de Inputs -->
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.maskedinput.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.maskMoney.min.js'))}}"></script>

    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/shadowbox/shadowbox.js'))}}"></script>
            
    <!-- FUNÇÕES -->
    <script type="text/javascript">
        Shadowbox.init();
    </script>

    @hasSection('js')
        @yield('js')
    @endif

        <script type="text/javascript">
            (function ($) {
                var basesite = "/template//"; 
                var base = "/"; 
                var ajaxbase = basesite + 'ajax/ajax-central.php';
                
                //$('.loading-filtro').css("display", "none");
                
                // FILTRO DE BUSCA DE IMOVEIS -> CIDADES
                $('.loadcidadeFiltro').change(function() {
                var id_cidade = $('#cidade option:selected').val(); 
                var bairro = $('.j_loadbairros'); 
                //Loading
                //$('.loading-filtro').css("display", "block");
                bairro.val('Carregando bairros...');
                bairro.fadeOut(500);
                $('.selectBairro').load(basesite + '/ajax/ajax-bairros.php?cidade=' + id_cidade);
                //$('.resultado').load(basesite + 'ajax/filtro-imoveis.php?cidade=' + id_cidade);
                //$('.loading-filtro').css("display", "none");
                });

                $('.loadtipo').change(function(){        
                    var tipo = $('#tipo option:selected').val();
                    if(tipo == 1){
                        $('.loadvalores').fadeOut(500);
                        $('.selectValores').load(basesite + 'ajax/ajax-tipos.php?tipo=' + tipo);
                    }else{
                        $('.loadvalores').fadeOut(500);
                        $('.selectValores').load(basesite + 'ajax/ajax-tipos.php?tipo=' + tipo);
                    }
                });

                // Seletor, Evento/efeitos, CallBack, Ação
                // $('.j_searchimoveis').submit(function (){
                //     var form = $(this);
                //     var data = $(this).serialize();
                //
                //     $.ajax({
                //         url: ajaxbase,
                //         data: data,
                //         type: 'POST',
                //         datatype: 'json',
                //
                //         beforeSend: function(){
                //             form.find('#b_nome').html('Carregando...');
                //             form.find('.alert').fadeOut(500, function(){
                //                 $(this).remove();
                //             });
                //         },
                //         success: function(){
                //
                //         },
                //         complete: function(){
                //             form.find('#b_nome').html('Pesquisar');
                //         }
                //     });
                //     return false;
                // });

                $('.rcomprar').css("display", "block");
                
                // SIMULADOR INICIO
                $('.financiamento').css("display", "none");
                $('.consorcio').css("display", "none");
                
                $('.loadtipo_s').change(function() {
                    if($(this).val() == 0){            
                        $('.financiamento').css("display", "block");
                        $('.consorcio').css("display", "none");
                        $('.opcaoconsorcio').prop('disabled', 'disabled');
                        $('.opcaofinanciamento').removeAttr('disabled');
                    }else{            
                        $('.consorcio').css("display", "block");
                        $('.financiamento').css("display", "none");
                        $('.opcaoconsorcio').removeAttr('disabled');
                        $('.opcaofinanciamento').prop('disabled', 'disabled');
                    }
                });   
                
                $('.j_submitsimulador').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.button-md').html("Carregando...");
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            $('html, body').animate({scrollTop:$('.alertas').offset().top-135}, 'slow'); 
                        if(resposta.error){                    
                                form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                                form.find('.alert-danger').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                                form.find('.alert-sucess').fadeIn();                    
                                form.find('input[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('.button-md').html("Enviar Agora");                               
                        }
                    });
                    return false;
                });
                // SIMULADOR FIM 
                
                // MASCARAS
                $("#valor").mask("999.999.999,99",{placeholder:" "});
                $("#nascimento").mask("99/99/9999");
                $("#whatsapp").mask("(99) 99999-9999",{placeholder:" "});
                $("#cep").mask("99.999-999");
                $("#rg").mask("99.999.999 - 9");
                
                $('#dinheiroComZero1').maskMoney({ decimal: ',', thousands: '.', precision: 2 });
                $('#dinheiroComZero2').maskMoney({ decimal: ',', thousands: '.', precision: 2 });
                $('#dinheiroComZero').maskMoney({ decimal: ',', thousands: '.', precision: 2 });
                $('.dinheiroComZero').maskMoney({ decimal: ',', thousands: '.', precision: 2 });
                //$('#dinheiroSemZero').maskMoney({ decimal: ',', thousands: '.', precision: 0 });
                //$('#dinheiroVirgula').maskMoney({ decimal: '.', thousands: ',', precision: 2 });
                
                    
                $('.j_loadstate').change(function() {
                    var uf = $('.j_loadstate');
                    var city = $('.j_loadcity');
                    var patch = basesite + 'ajax/cidades.php';

                    city.attr('disabled', 'true');
                    uf.attr('disabled', 'true');

                    city.html('<option value=""> Carregando cidades... </option>');

                    $.post(patch, {estado: $(this).val()}, function(cityes) {   
                        city.html(cityes).removeAttr('disabled');
                        uf.removeAttr('disabled');
                    });
                });
                
                // CONSULTA NA PÁGINA DOS IMÓVEIS
                $('.j_formsubmitconsulta').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.b_nome').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            //console.clear();
                            //console.log(resposta);
                            //$('html, body').animate({scrollTop:0}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                                form.find('.alert-danger').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                                form.find('.alert-success').fadeIn();                    
                                //form.find('input[class!="noclear"]').val('');
                                //form.find('textarea[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('.b_nome').html("Consultar Agora");                                
                        }
                        
                    });
                    
                    return false;
                });
                
                // Seletor, Evento/efeitos, CallBack, Ação
                $('.j_formsubmit').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('#b_nome').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            //console.clear();
                            //console.log(resposta);
                            $('html, body').animate({scrollTop:0}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="dt-sc-error-box">'+ resposta.error +'</div>');
                                form.find('.dt-sc-error-box').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="dt-sc-success-box">'+ resposta.sucess +'</div>');
                                form.find('.dt-sc-success-box').fadeIn();                    
                                //form.find('input[class!="noclear"]').val('');
                                //form.find('textarea[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('#b_nome').html("Enviar Agora");                                
                        }
                        
                    });
                    
                    return false;
                });
                
                // Seletor, Evento/efeitos, CallBack, Ação
                $('.j_formsubmitcomentario').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('#b_nome').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            //console.clear();
                            //console.log(resposta);
                            $('html, body').animate({scrollTop:$('.alertas').offset().top-135}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                                form.find('.alert-message').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                                form.find('.alert-message').fadeIn();                    
                                form.find('input[class!="noclear"]').val('');
                                form.find('textarea[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('#b_nome').html("Enviar Comentário");                                
                        }
                        
                    });        
                    return false;
                });
                
                // Seletor, Evento/efeitos, CallBack, Ação
                $('.j_formsubmitanuncioSend').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('#b_nome').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            //console.clear();
                            //console.log(resposta);
                            $('html, body').animate({scrollTop:0}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                                form.find('.alert-message').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                                form.find('.alert-message').fadeIn();                    
                                //form.find('input[class!="noclear"]').val('');
                                //form.find('textarea[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('#b_nome').html("Enviar Mensagem");                                
                        }
                        
                    });        
                    return false;
                });
                
                    
                // Seletor, Evento/efeitos, CallBack, Ação
                //$('.j_formcadastro').submit(function (){

                // var data = new FormData(this);

                // var form = $(this);
                    //var data = $(this).serialize();
                    
            //        var Acbanco = new Array();
            // 
            //        $("input[name='acbanco[]']").each(function(){
            //           Codigos.push($(this).val());
            //        });
                    
            //        $.ajax({
            //            url: ajaxbase,
            //            data: data,
            //            type: 'POST',
            //            mimeType: "multipart/form-data",
            //            dataType: 'json',
            //            contentType: false,
            //            cache: false,
            //            processData:false,
            //            
            //            beforeSend: function(){
            //                form.find('.b_cadastro').html("Carregando...");                
            //                form.find('.alert').fadeOut(500, function(){
            //                    $(this).remove();
            //                });
            //            },
            //            success: function(resposta){
            //                $('html, body').animate({scrollTop:$('.alertas').offset().top-135}, 'slow');
            //                if(resposta.error){
            //                    form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
            //                    form.find('.alert-danger').fadeIn(); 
            //                    console.log(resposta);
            //                }else{
            //                    form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
            //                    form.find('.alert-success').fadeIn();                    
            //                    //form.find('input[class!="noclear"]').val('');
            //                    //form.find('textarea[class!="noclear"]').val('');
            //                    //form.find('.form_hide').fadeOut(500);
            //                    console.log(resposta);
            //                }
            //            },
            //            complete: function(resposta){
            //                form.find('.b_cadastro').html("Cadastrar");                                
            //            }
            //            
            //        });
            //        
            //        return false;
            //    });

                $('.btn1').on('click', function() {$('.arquivo1').trigger('click');});
                $('.btn2').on('click', function() {$('.arquivo2').trigger('click');});
                $('.btn3').on('click', function() {$('.arquivo3').trigger('click');});
                $('.btn4').on('click', function() {$('.arquivo4').trigger('click');});
                $('.btn5').on('click', function() {$('.arquivo5').trigger('click');});
                $('.btn6').on('click', function() {$('.arquivo6').trigger('click');});

                $('.arquivo1').on('change', function() {var fileName = $(this)[0].files[0].name;$('#file1').val(fileName);});
                $('.arquivo2').on('change', function() {var fileName = $(this)[0].files[0].name;$('#file2').val(fileName);});
                $('.arquivo3').on('change', function() {var fileName = $(this)[0].files[0].name;$('#file3').val(fileName);});
                $('.arquivo4').on('change', function() {var fileName = $(this)[0].files[0].name;$('#file4').val(fileName);});
                $('.arquivo5').on('change', function() {var fileName = $(this)[0].files[0].name; $('#file5').val(fileName); });
                $('.arquivo6').on('change', function() {var fileName = $(this)[0].files[0].name; $('#file6').val(fileName);});
                
                // Seletor, Evento/efeitos, CallBack, Ação
                $('.j_formNewsletter').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.b_cadastro').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            //console.clear();
                            //console.log(resposta);
                            //$('html, body').animate({scrollTop:0}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                                form.find('.alert-danger').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                                form.find('.alert-success').fadeIn();                    
                                //form.find('input[class!="noclear"]').val('');
                                //form.find('textarea[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('.b_cadastro').html("Cadastrar");                                
                        }
                        
                    });
                    
                    return false;
                });
                
                // Seletor, Evento/efeitos, CallBack, Ação
                $('.j_formAtualiza').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.b_atualiza').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            $('html, body').animate({scrollTop:0}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="dt-sc-error-box">'+ resposta.error +'</div>');
                                form.find('.dt-sc-error-box').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="dt-sc-success-box">'+ resposta.sucess +'</div>');
                                form.find('.dt-sc-success-box').fadeIn();                    
                                //form.find('input[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('.b_atualiza').html("Atualizar");                                
                        }
                        
                    });
                    
                    return false;
                });
                
                
                // Seletor, Evento/efeitos, CallBack, Ação
                $('.j_formLogin').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.b_login').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            //console.clear();
                            //console.log(resposta);
                            $('html, body').animate({scrollTop:0}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="dt-sc-error-box">'+ resposta.error +'</div>');
                                form.find('.dt-sc-error-box').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="dt-sc-success-box">'+ resposta.sucess +'</div>');
                                form.find('.dt-sc-success-box').fadeIn();                    
                                //form.find('input[class!="noclear"]').val('');
                                //form.find('textarea[class!="noclear"]').val('');
                                //form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('.b_login').html("<i class=\"fa fa-check-circle\"> </i> Logar");                                
                        }
                        
                    });
                    
                    return false;
                });
                
                // Seletor, Evento/efeitos, CallBack, Ação
                $('.j_formtoken').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.b_token').html("Carregando...");                
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            //console.clear();
                            //console.log(resposta);
                            $('html, body').animate({scrollTop:0}, 'slow');
                            if(resposta.error){
                                form.find('.alertas').html('<div class="dt-sc-error-box">'+ resposta.error +'</div>');
                                form.find('.dt-sc-error-box').fadeIn();                    
                            }else if(resposta.checklogin){
                                window.setTimeout(function(){
                                    $(location).attr('href','/atletas/' + resposta.checklogin);
                                },1000);
                            }else{
                                form.find('.alertas').html('<div class="dt-sc-success-box">'+ resposta.sucess +'</div>');
                                form.find('.dt-sc-success-box').fadeIn();                    
                                //form.find('input[class!="noclear"]').val('');
                                //form.find('textarea[class!="noclear"]').val('');
                                form.find('.form_hide').fadeOut(500);
                            }
                        },
                        complete: function(resposta){
                            form.find('.b_token').html("<i class=\"fa fa-check-circle\"> </i> Solicitar Token");                                
                        }
                        
                    });
                    
                    return false;
                });
                
                //FUNÇÕES DO FORM DE NEWSLETTER
                $('.j_formsearch').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                        if(resposta.error){    
                                form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                                form.find('.alert-danger').fadeIn();
                            }else if(resposta.returnSearch){
                                window.setTimeout(function(){
                                    $(location).attr('href','/blog/pesquisa&search=' + resposta.returnSearch);
                                },1000);
                            }else{
                                form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                                form.find('.alert-sucess').fadeIn();
                            }
                        },
                        complete: function(resposta){
                                                        
                        }
                    });
                    return false;
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
                
                // botão do whatsapp
                $('.j_btnwhats').click(function (){         
                    $('.balao').slideDown();
                    return false;
                });
                
                
                
                
                //FUNÇÕES DO FORM DE BUSCA AVANÇADA
                $('.j_formsubmitbusca').submit(function (){
                    var form = $(this);
                    var data = $(this).serialize();
                    
                    $.ajax({
                        url: ajaxbase,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        
                        beforeSend: function(){
                            form.find('.search-button').html("Carregando...");
                            form.find('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                        $('html, body').animate({scrollTop:100}, 'slow'); 
                        if(resposta.error){                    
                                form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                                form.find('.alert-danger').fadeIn();                    
                            }else{
                                form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                                form.find('.alert-sucess').fadeIn();                    
                                form.find('input[class!="noclear"]').val('');
                                window.setTimeout(function(){
                                    $(location).attr('href',base + 'imoveis/busca-avancada' + 
                                    '&cidade=' + $('.loadcidadeFiltro').val() + 
                                    '&bairro=' + $('.j_loadbairros').val() +
                                    '&categoria=' + $('.loadfinalidade').val() +
                                    '&subcategoria=' + $('.loadcategoria').val() +
                                    '&dormitorios=' + $('.loaddormitorios').val() +
                                    '&tipo=' + $('.loadtipo').val());
                                },1000);                   
                            }
                        },
                        complete: function(resposta){
                            form.find('.search-button').html("Buscar Imóveis");                               
                        }
                    });
                    return false;
                });  
                
                
                
            })(jQuery);   
                
            </script>
    </body>
</html>