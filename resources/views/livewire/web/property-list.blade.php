<div>
    <div class="properties-details-page content-area">
        <div class="content-area featured-properties">
            <div class="container">
                <div class="row">
                    <div class="filtr-container">
                        @forelse($properties as $property)
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="property" style="min-height: 440px !important;">                                
                                    <div class="property-img">
                                        <div class="property-tag button alt featured">
                                            Referência: {{$property->reference}}
                                        </div>
                                        <div class="property-tag button sale">
                                            @if($property->sale && !$property->location)
                                                Venda
                                            @elseif($property->sale && $property->location)
                                                Venda/Locação
                                            @else
                                                Locação
                                            @endif
                                        </div>
                                        <div class="property-price">
                                            @if($property->display_values)
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
                                            @endif
                                        </div>
                                        <img style="min-height: 240px !important;" src="{{$property->cover()}}" alt="{{$property->title}}" class="img-responsive"/>
                                        <div class="property-overlay">
                                            <a href="{{route('web.property',['slug' => $property->slug])}}" class="overlay-link">
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
                                    <div class="property-content">
                                        <h1 class="title">
                                            <a href="{{route('web.property',['slug' => $property->slug])}}">{{$property->title}}</a>
                                        </h1>
                                        @if ($property->neighborhood)
                                            <h3 class="property-address">
                                                <a href="{{route('web.property',['slug' => $property->slug])}}">
                                                    <i class="fa fa-map-marker"></i> {{$property->neighborhood}}, {{$property->city}} / {{$property->state}}
                                                </a>
                                            </h3>                                        
                                        @endif
                                        <ul class="facilities-list clearfix">
                                            @if ($property->total_area)
                                                <li>
                                                    <i class="flaticon-square-layouting-with-black-square-in-east-area"></i>
                                                    <span>{{$property->total_area}} {{$property->measures}}</span>
                                                </li>                                            
                                            @endif
                                            @if ($property->dormitories)
                                                <li>
                                                    <i class="flaticon-bed"></i>
                                                    <span>{{$property->dormitories}}</span>
                                                </li>                                            
                                            @endif
                                            @if ($property->bathrooms)
                                                <li>
                                                    <i class="flaticon-holidays"></i>
                                                    <span>{{$property->bathrooms}}</span>
                                                </li>                                            
                                            @endif
                                            @if ($property->garage)
                                                <li>
                                                    <i class="flaticon-vehicle"></i>
                                                    <span>{{$property->garage}}</span>
                                                </li>                                            
                                            @endif                                        
                                        </ul>                            
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full text-center mt-8">Nenhum imóvel encontrado!</p>
                        @endforelse 
                        
                        
                    </div>   
                    @if ($properties->hasMorePages())
                        <div class="col-12 mt-8 p-4 text-center">
                            <button wire:click="loadMore"
                                class="px-6 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg font-medium">
                                Carregar mais imóveis
                            </button>
                        </div>
                    @endif         
                </div>
            </div>
        </div>
    </div>
</div>
