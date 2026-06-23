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
        
        <!-- Google fonts -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">  
        
        <style>
            [x-cloak] { display: none !important; }          
        </style>

        @vite(['resources/css/app.css', 'resources/js/front.js'])
        
        @hasSection('css')
            @yield('css')
        @endif    

    </head>
    <body x-data="cookieConsent">       
    
    {{-- HEADER --}}
    @include('web.' . $configuracoes->template . '.master.header')

    @yield('content')

    {{-- FOOTER --}}
    @include('web.' . $configuracoes->template . '.master.footer')

    {{-- Copyright --}}  
    @include('web.' . $configuracoes->template . '.master.copyright')

    <!-- BANNER -->
    <div 
        x-cloak
        x-show="!accepted"
        class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 z-40"
    >
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <p>
                Utilizamos cookies para melhorar sua experiência.
            </p>

            <div class="flex gap-3">
                <button @click="acceptAll()" class="bg-green-600 px-4 py-2 rounded">
                    Aceitar todos
                </button>

                <button @click="openModal()" class="bg-gray-600 px-4 py-2 rounded">
                    Preferências
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div 
        x-cloak
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        @click.self="closeModal()"
    >
        <div class="bg-white text-black p-6 rounded w-96 relative">
            
            <button 
                @click="closeModal()" 
                class="absolute top-2 right-2 text-gray-500"
            >
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4">Preferências de Cookies</h2>

            <label class="block mb-2">
                <input type="checkbox" checked disabled>
                Essenciais
            </label>

            <label class="block mb-2">
                <input type="checkbox" x-model="stats">
                Estatísticos
            </label>

            <label class="block mb-4">
                <input type="checkbox" x-model="marketing">
                Marketing
            </label>

            <button 
                @click="save()" 
                class="bg-blue-600 text-white px-4 py-2 rounded w-full"
            >
                Salvar preferências
            </button>
        </div>
    </div> 

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


    

    <!-- Máscara de Inputs -->
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.maskedinput.min.js'))}}"></script>
    <script type="text/javascript" src="{{url(asset('frontend/'.$configuracoes->template.'/js/jquery.maskMoney.min.js'))}}"></script>

    
    
    @hasSection('js')
        @yield('js')
    @endif

        <script type="text/javascript">
            (function ($) {

                // WOW animation library initialization
                var wow = new WOW(
                    {
                        animateClass: 'animated',
                        offset: 100,
                        mobile: false
                    }
                );
                wow.init();

                // Multilevel menuus
                $('[data-submenu]').submenupicker();

                

                // Background video playing script
                $(document).ready(function () {
                    $(".player").mb_YTPlayer();
                });

            })(jQuery);   
                
        </script>
        
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-N73T2G5HFS"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-N73T2G5HFS');
        </script>
    </body>
</html>