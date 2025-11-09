@extends("web.$configuracoes->template.master.master")

@section('content')
    <livewire:web.property-filter />
    <livewire:web.property-list />
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