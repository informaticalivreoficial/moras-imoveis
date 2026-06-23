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
                <a target="_blank" style="margin-top: 5px;margin-bottom: 5px;" href="{{route('web.simulator')}}" class="btn button-sm border-button-theme">financiamento</a>
                <a style="margin-top: 5px;margin-bottom: 5px;margin-left: 10px;" href="{{route('web.pesquisar-imoveis')}}" class="btn button-sm border-button-theme">Buscar Imóveis</a>
                                        
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
                                href="{{($menuItem->type == 'pagina' ? route('web.page', [ 'slug' => ($menuItem->post != null ? $menuItem->PostObject->slug : '#') ]) : $menuItem->url)}}">
                                {{ $menuItem->title }}{!!($menuItem->children && $menuItem->parent ? "<span class=\"caret\"></span>" : '')!!}
                            </a>
                            @if( $menuItem->children && $menuItem->parent)
                                <ul class="dropdown-menu">
                                    @foreach($menuItem->children as $subMenuItem)
                                    <li class="dropdown-submenu">
                                        <a {{($subMenuItem->target == 1 ? 'target=_blank' : 'target=_self')}} href="{{($subMenuItem->tipo == 'Página' ? route('web.page', [ 'slug' => ($subMenuItem->post != null ? $subMenuItem->PostObject->slug : '#') ]) : $subMenuItem->url)}}">{{ $subMenuItem->title }}</a>
                                    </li>                                        
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @endif
                <li class="dropdown">
                    <a title="Imóveis" class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Imóveis
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-submenu" href="{{route('web.propertylist', ['type' => 'venda'])}}" title="Comprar">Comprar</a></li>
                        <li><a class="dropdown-submenu" href="{{route('web.propertylist', ['type' => 'locacao'])}}" title="Alugar">Alugar</a></li>
                    </ul>
                </li>
                @if (!empty($lancamentoMenu) && $lancamentoMenu->count() > 0)
                    <li><a href="{{route('web.highliths')}}" title="Lançamentos">Lançamentos</a></li>
                @endif 
                <li><a href="{{route('web.contact')}}">Atendimento</a></li>                        
            </ul>
            
            {{--
            <ul class="nav navbar-nav navbar-right rightside-navbar">
                <li>
                    <a href="" class="button">
                        Cadastre seu Imóvel
                    </a>
                </li>
            </ul>
            --}}
        </div>
    </nav>
</div>
</header>