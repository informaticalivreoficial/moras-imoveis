<div>
    @if (!empty($highlight) && $highlight->count() > 0)
        <div class="properties-section property-big content-area" style="padding-bottom:0px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="property property-hp row g-0 fp2 clearfix wow fadeInUp delay-03s">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <!-- Property img -->
                                <div class="property-img">
                                    <div class="property-tag button alt featured">Destaque</div>
                                    <div class="property-tag button sale">{{($highlight->sale == 1 ? 'Venda' : 'Locação')}}</div>
                                    @if($highlight->display_values == 1)
                                        @if(!empty($type) && $type == 'venda')
                                            <div class="property-price">R${{str_replace(',00', '', $highlight->sale_value)}}</div>
                                        @elseif($highlight->location == 1 && $highlight->sale == 0)
                                            <div class="property-price"><b>Aluguel:</b> R${{ str_replace(',00', '', $highlight->rental_value) }}/{{$highlight->getLocationPeriod()}}</div>
                                        @else
                                            @if($highlight->sale == 1 && !empty($highlight->sale_value) && $highlight->location == 1 && !empty($highlight->rental_value))
                                                    <div class="property-price"><b>Valor do Imóvel:</b> R${{ str_replace(',00', '', $highlight->sale_value) }} <br>
                                                    <b>ou Valor do Aluguel:</b> R${{ str_replace(',00', '', $highlight->rental_value) }}/{{$highlight->getLocationPeriod()}}</div>
                                            @elseif($highlight->sale == 1 && !empty($highlight->sale_value))
                                                <div class="property-price">R${{ str_replace(',00', '', $highlight->sale_value) }}</div>
                                            @elseif($highlight->location == 1 && !empty($highlight->rental_value))
                                                <div class="property-price"><b>Aluguel:</b> R${{ str_replace(',00', '', $highlight->rental_value) }}/{{$highlight->getLocationPeriod()}}</div>
                                            @else
                                                <div class="property-price">Sob Consulta!</div>
                                            @endif
                                        @endif
                                    @endif
                                    <img src="{{--$highlight->cover()--}}https://informatica-livre.s3.us-east-2.amazonaws.com/superimoveis/imoveis/5282bcb2-59b0-47ec-9efb-932faba32ea6/444/aluguel-temporada-16867535339626.jpg" alt="{{$highlight->title}}" class="img-fluid w-100">
                                    <div class="property-overlay">
                                        <a href="{{ route(($highlight->location == 1 ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $highlight->slug]) }}" class="overlay-link">
                                            <i class="fa fa-link"></i>
                                        </a>
                                        @if ($highlight->youtube_video)
                                            <a class="overlay-link property-video" title="{{$highlight->title}}" data-embed="{{getEmbedYoutube($highlight->youtube_video)}}">
                                                <i class="fa fa-video-camera"></i>
                                            </a>
                                        @endif
                                        <div class="property-magnify-gallery">
                                            <a href="{{$highlight->cover()}}" class="overlay-link">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                            @if($highlight->images()->get()->count())
                                                @foreach($highlight->images()->get() as $image)
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
                                        <a href="{{ route(($highlight->location == 1 ? 'web.buyProperty' : 'web.rentProperty'), ['slug' => $highlight->slug]) }}">{{$highlight->title}}</a>
                                    </h1>
                                    <!-- Property address -->
                                    <h3 class="property-address">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-map-marker"></i>{{$highlight->neighborhood}} - {{$highlight->city}}
                                        </a>
                                    </h3>
                                    <!-- Facilities List -->
                                    <ul class="facilities-list clearfix">
                                        @if ($highlight->useful_area)
                                            <li>
                                                <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                                <span>{{$highlight->useful_area}}{{$highlight->measures}} Área útil</span>
                                            </li>
                                        @endif
                                        @if ($highlight->total_area)
                                            <li>
                                                <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                                <span>{{$highlight->total_area}}{{$highlight->measures}} Área total</span>
                                            </li>
                                        @endif
                                        @if ($highlight->dormitories)
                                            <li>
                                                <i class="flaticon-bed"></i>
                                                <span>{{$highlight->dormitories}} Dormitórios</span>
                                            </li>
                                        @endif
                                        @if ($highlight->bathrooms)
                                            <li>
                                                <i class="flaticon-holidays"></i>
                                                <span>{{$highlight->bathrooms}} Banheiros</span>
                                            </li>
                                        @endif                                    
                                        <li>
                                            <i class="flaticon-vehicle"></i>
                                            <span>
                                                @php
                                                if(!empty($highlight->garage) && !empty($highlight->covered_garage)){
                                                    $g = $highlight->garage + $highlight->covered_garage;
                                                    echo $g.' Garagem';
                                                }elseif(!empty($highlight->garage) && empty($highlight->covered_garage)){
                                                    echo $highlight->garage.' Garagem';
                                                }else{
                                                    echo $highlight->covered_garage.' Garagem';
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
</div>
