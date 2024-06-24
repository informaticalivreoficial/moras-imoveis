@extends("web.{$configuracoes->template}.master.master")

@section('content')
<contact-form></contact-form>
<div class="sub-banner" style="background: rgba(0, 0, 0, 0.04) url({{$configuracoes->gettopodosite()}}) top left repeat;">
    <div class="overlay">
        <div class="container">
            <div class="breadcrumb-area">
                <h1>Atendimento</h1>
                <ul class="breadcrumbs">
                    <li><a href="{{route('web.home')}}">Home</a></li>
                    <li class="active">Atendimento</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Contact 1 start -->


<div class="contact-1 content-area-7">
    <div class="container">
       <div class="bg-white">
            <div class="row g-0">
                <div class="col-lg-7 col-md-12 col-sm-12 col-pad2">
                    <!-- Contact form start -->
                    <div class="contact-form contact-pad">
                        <form class="j_formsubmit" id="contact_form" action="" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div id="js-contact-result"></div>
                                </div>                                
                                <!-- HONEYPOT -->
                                <input type="hidden" class="noclear" name="tenant_id" value="{{$configuracoes->id}}" />
                                <input type="hidden" class="noclear" name="bairro" value="" />
                                <input type="text" class="noclear" style="display: none;" name="cidade" value="" />                                
                            </div>
                            <div class="row form_hide">
                                <div class="col-md-6">
                                    <div class="form-group name">
                                        <input type="text" name="nome" class="form-control" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group email">
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group subject">
                                        <input type="text" name="assunto" class="form-control" placeholder="Assunto">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group number">
                                        <input type="text" name="telefone" class="form-control telefonemask" placeholder="Telefone">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group message">
                                        <textarea  class="form-control" name="mensagem" placeholder="Mensagem"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="send-btn text-center">
                                        <button type="submit" id="b_nome" class="button-md button-theme btn-3">Enviar Agora</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact form end -->
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-pad2">
                    <!-- Contact details start -->
                    <div class="contact-details">
                        <h3>Nossos Canais</h3>
                        <div class="ci-box d-flex">
                            <div class="icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            @if ($configuracoes->rua)
                                <div class="detail align-self-center">
                                    <h4>Escritório</h4>
                                    <p>
                                       {{$configuracoes->rua}}
                                       {{($configuracoes->num ? ', '.$configuracoes->num : '')}}  
                                       {!!($configuracoes->bairro ? '<br> '.$configuracoes->bairro : '')!!}  
                                       {{($configuracoes->cidade ? ', '.getCidade($configuracoes->cidade, 'cidades') : '')}} 
                                    </p>
                                </div>
                            @endif
                        </div>
                        @if ($configuracoes->telefone || $configuracoes->celular)
                            <div class="ci-box d-flex">
                                <div class="icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="detail align-self-center">
                                    <h4>Telefone</h4>
                                    <p>
                                        <a href="tel:{{$configuracoes->telefone}}">{{$configuracoes->telefone}} </a>
                                        @if ($configuracoes->celular)
                                        <a href="tel:{{$configuracoes->celular}}"> {{$configuracoes->celular}}</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($configuracoes->email)
                            <div class="ci-box d-flex">
                                <div class="icon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="detail align-self-center">
                                    <h4>Email</h4>
                                    <p>
                                        <a href="mailto:{{$configuracoes->email}}">{{$configuracoes->email}}</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($configuracoes->email1)
                            <div class="ci-box d-flex">
                                <div class="icon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="detail align-self-center">
                                    <h4>Email</h4>
                                    <p>
                                        <a href="mailto:{{$configuracoes->email1}}">{{$configuracoes->email1}}</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($configuracoes->whatsapp)
                            <div class="ci-box d-flex mb-30">
                                <div class="icon">
                                    <i class="fa fa-whatsapp"></i>
                                </div>
                                <div class="detail align-self-center">
                                    <h4>WhatsApp:</h4>
                                    <p>
                                        <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->name)}}">{{$configuracoes->whatsapp}}</a>
                                    </p>
                                </div>
                            </div>
                        @endif

                        <h3>Siga-nos</h3>
                        <ul class="social-list clearfix">
                            @if ($configuracoes->facebook)
                                <li><a target="_blank" class="facebook-bg" href="{{$configuracoes->facebook}}"><i class="fa fa-facebook"></i></a></li>
                            @endif
                            @if ($configuracoes->twitter)
                                <li><a target="_blank" class="twitter-bg" href="{{$configuracoes->twitter}}"><i class="fa fa-twitter"></i></a></li>
                            @endif
                            @if ($configuracoes->instagram)
                                <li><a target="_blank" class="instagram-bg" href="{{$configuracoes->instagram}}"><i class="fa fa-instagram"></i></a></li>
                            @endif
                            @if ($configuracoes->linkedin)
                                <li><a target="_blank" class="linkedin-bg" href="{{$configuracoes->linkedin}}"></a><i class="fa fa-linkedin"></i></li>
                            @endif
                            @if ($configuracoes->youtube)
                                <li><a target="_blank" class="youtube-bg" href="{{$configuracoes->youtube}}"><i class="fa fa-youtube"></i></a></li>
                            @endif                            
                            <li>
                                <a target="_blank" href="{{route('web.feed')}}" class="rss-bg">
                                    <i class="fa fa-rss"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Contact details end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact 1 end -->

<!-- Google map start -->
<div class="section">
    <div class="map">
        <div id="map" class="contact-map"></div>
    </div>
</div>
<!-- Google map end -->
@endsection

@section('js')
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $telefone = $(".telefonemask");
        $telefone.mask('(99) 9999-9999', {reverse: false});               
    });
</script>
  <script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.sendEmail') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-contact-btn").attr("disabled", true);
                    form.find('#js-contact-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(resposta){
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-100}, 'slow');
                    if(resposta.error){
                        form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-contact-result').html('<div class="alert alert-success error-msg">'+ resposta.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('textarea[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html("Enviar Agora");                                
                }
            });

            return false;
        });

    });
</script>   
@endsection