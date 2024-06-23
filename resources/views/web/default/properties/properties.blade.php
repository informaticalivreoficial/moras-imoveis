@extends("web.{$configuracoes-->template}.master.master")

@section('content')

@if (!empty($properties) && $properties->count() > 0)

<div class="sub-banner" style="background: rgba(0, 0, 0, 0.04) url({{$configuracoes-->gettopodosite()}}) top left repeat;">
    <div class="overlay">
        <div class="container">
            <div class="breadcrumb-area">
                <h1>Imóveis para {{$type}}</h1>
                <ul class="breadcrumbs">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Imóveis para {{$type}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="properties-section-body content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 scrolling-pagination">               
                <div class="row">
                    @foreach ($properties as $imovel)
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 wow fadeInUp delay-03s">
                        <!-- Property start -->
                        <div class="property fp2">
                            <!-- Property img -->
                            <div class="property-img">
                                @if ($imovel->referencia)
                                    <div class="property-tag button alt featured">Ref.: {{$imovel->referencia}}</div>
                                @endif                                
                                <div class="property-tag button sale">{{$imovel->tipo}}</div>
                                <div class="property-price">
                                    @if(!empty($type) && $type == 'venda')
                                        R$ {{str_replace(',00', '', $imovel->valor_venda)}}                                                        
                                    @elseif(!empty($type) && $type == 'locacao')
                                        R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}
                                    @else
                                        @if($imovel->venda == true && !empty($imovel->valor_venda) && $imovel->valor_locacao == true && !empty($imovel->valor_locacao))                                            
                                                Venda: R${{ str_replace(',00', '', $imovel->valor_venda) }}<br>
                                                Aluguel: R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}                                            
                                        @elseif($imovel->venda == true && !empty($imovel->valor_venda))
                                                R${{ str_replace(',00', '', $imovel->valor_venda) }}
                                        @elseif($imovel->locacao == true && !empty($imovel->valor_locacao))
                                                R${{ str_replace(',00', '', $imovel->valor_locacao) }}/{{$imovel->getLocacaoPeriodo()}}
                                        @else
                                            Sob Consulta
                                        @endif
                                    @endif
                                </div>
                                <img style="min-height:262px !important;max-height: 262px !important;max-width: 100%;" src="{{$imovel->cover()}}" alt="{{$imovel->titulo}}">
                                <div class="property-overlay">
                                    <a href="{{ route((session('venda') == true || (!empty($type) && $type == 'venda') || ($imovel->locacao == false) ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $imovel->slug]) }}" class="overlay-link">
                                        <i class="fa fa-link"></i>
                                    </a>
                                    @if ($imovel->youtube_video)
                                        <a class="overlay-link property-video" title="{{$imovel->titulo}}" data-embed="{{getEmbedYoutube($imovel->youtube_video)}}">
                                            <i class="fa fa-video-camera"></i>
                                        </a>
                                    @endif                                                                        
                                </div>
                            </div>
                            <!-- Property content -->
                            <div class="property-content">
                                <!-- info -->
                                <div class="info">
                                    <!-- title -->
                                    <h1 class="title">
                                        <a href="{{ route((session('venda') == true || (!empty($type) && $type == 'venda') || ($imovel->locacao == false) ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $imovel->slug]) }}">{{$imovel->titulo}}</a>
                                    </h1>
                                    <!-- Property address -->
                                    <h3 class="property-address">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-map-marker"></i>{{$imovel->bairro}} - {{getCidadeNome($imovel->cidade, 'cidades')}}
                                        </a>
                                    </h3>
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
                        <!-- Property end -->
                    </div>
                    @endforeach 
                    {{$properties->links()}}                   
                </div>                
            </div>
        </div>
    </div>
</div>


<!-- Video Modal -->
<div class="modal property-modal fade" id="propertyModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row modal-raw g-0">
                    <div class="col-12 modal-left">
                        <div class="modal-left-content">
                            <iframe class="modalIframe w-100" src="" allowfullscreen></iframe>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>

@else
<div class="properties-section-body content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12"> 
                <div class="nobottomborder">
                    <h1>Desculpe não foram encontrados resultados!</h1>
                    <a class="btn-1 btn-outline-1" href="{{route('web.home')}}">
                        <span>Voltar ao início</span> <i class="arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script>
        // Paginação infinita
        $('ul.pagination').hide();
        $(function() {
            $('.scrolling-pagination').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scrolling-pagination',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });  
        
        // Modal Vídeo
        $(document).on('click', '.property-video', function () {
            var embed = $(this).data('embed');
            $('.modalIframe').prop('src', embed);
            $('#propertyModal').modal('show');
        });

        $(".close").click(function(){
            $('.modalIframe').prop('src', '');
        });
    </script>    
@endsection