@extends("web.$configuracoes->template.master.master")

@section('content')
    <div class="sub-banner overview-bgi" style="background: rgba(0, 0, 0, 0.04) url({{$configuracoes->getheadersite()}}) top left repeat;">
        <div class="overlay">
            <div class="container">
                <div class="breadcrumb-area">
                    <h1 style="font-size: 36px;">Lançamentos</h1>
                    <ul class="breadcrumbs">
                        <li><a href="{{route('web.home')}}">Início</a></li>
                        <li class="active">Lançamentos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <livewire:web.property-list 
        :highlighted="true" 
        title="Imóveis em Destaque" 
    />
@endsection

@section('css')
    
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