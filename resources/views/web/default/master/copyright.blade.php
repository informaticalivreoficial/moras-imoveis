<div class="copy-right">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-8 col-sm-12">
                    &copy;  {{$configuracoes->init_date}} {{$configuracoes->app_name}} - Todos os direitos reservados.
                </div>
                <div class="col-md-4 col-sm-12">
                    <ul class="social-list clearfix">
                        @if ($configuracoes->facebook)
                            <li>
                                <a target="_blank" href="{{$configuracoes->facebook}}" class="facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>                            
                        @endif
                        @if ($configuracoes->twitter)
                            <li>
                                <a target="_blank" href="{{$configuracoes->twitter}}" class="twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if ($configuracoes->linkedin)
                            <li>
                                <a target="_blank" href="{{$configuracoes->linkedin}}" class="linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        @endif
                        @if ($configuracoes->instagram)
                            <li>
                                <a target="_blank" href="{{$configuracoes->instagram}}" class="instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                        @endif                        
                    </ul>
                    <span class="small text-silver-dark">Feito com <i style="color:red;" class="fa fa-heart"></i> por <a style="color:#fff;" target="_blank" href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a></span>                    
                </div>
            </div>
        </div>
    </div>