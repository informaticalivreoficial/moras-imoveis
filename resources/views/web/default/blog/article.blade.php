@extends("web.$configuracoes->template.master.master")

@section('content')
<div class="blog-body content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-xs-12 col-md-push-4">
                <!-- Blog box start -->
                <div class="thumbnail blog-box clearfix">                
                    <img src="{{$post->cover()}}" alt="{{$post->title}}" class="img-responsive"/>
                    <div class="caption detail">
                        <!--Main title -->
                        <h3 class="title">
                            {{$post->title}}
                        </h3>
                        <!-- Post meta -->
                        <div class="post-meta">
                            <span><a href="#"><i class="fa fa-user"></i>{{$post->user->name}}</a></span>
                            <span><a><i class="fa fa-calendar "></i>{{ $post->created_at->format('d M, Y') }}</a></span>
                            <span><a href="#"><i class="fa fa-bars"></i> {{$post->categoryObject->title}}</a></span>                        
                            <span><a href="#"><i class="fa fa-comments"></i>{{$post->commentsCount()}}</a></span>
                        </div>
                        <!-- Social list -->
                        <div id="shareIcons"></div>
                        {!!$post->content!!}
                        
                        @if ($post->images()->get()->count())
                            <div class="row clearfix t-s">                            
                                @foreach($post->images()->get() as $gb)
                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                        <div class="agent-1">
                                            <a 
                                                data-fancybox="gallery"
                                                data-caption="{{ $post->title }}" 
                                                href="{{ $gb->url_image }}" 
                                                class="agent-img"
                                            >
                                                <img src="{{ $gb->url_cropped }}" alt="{{ $post->titulo }}" class="img-responsive">
                                            </a>
                                        </div>                                
                                    </div>
                                @endforeach                          
                            </div>
                        @endif                        
                        
                        <div class="row clearfix t-s">
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                @if($postsTags->count())                                        
                                    <div class="tags-box">
                                        <h2>Tags</h2>                        
                                        <ul class="tags">                            
                                            @foreach($postsTags as $tags)
                                                @php
                                                    $array = explode(',', $tags->tags);
                                                @endphp
                                                @php
                                                    $tipo = $tags->type == 'noticia' ? 'noticia' : 'artigo';
                                                @endphp
                                                @foreach($array as $tag)
                                                    @php $tag = trim($tag); @endphp
                                                    <li>
                                                        <a href="{{ route('web.blog.'.$tipo,['slug' => $tags->slug]) }}">{{ $tag }}</a>
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif                  
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <!-- Compartilhar -->
                                @php
                                    $url = urlencode(request()->fullUrl());
                                    $title = urlencode($post->title);
                                @endphp

                                <div class="mt-10 pt-8 border-t border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                                        Compartilhe
                                    </h3>
                                    <div class="flex flex-wrap gap-3">

                                        <!-- Facebook -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                                        target="_blank"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-[#1877F2] text-white hover:scale-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M22 12a10 10 0 10-11.63 9.87v-6.99h-2.8V12h2.8V9.8c0-2.76 1.64-4.3 4.15-4.3 1.2 0 2.45.21 2.45.21v2.7h-1.38c-1.36 0-1.78.84-1.78 1.7V12h3.03l-.48 2.88h-2.55v6.99A10 10 0 0022 12z"/>
                                            </svg>
                                        </a>

                                        <!-- X -->
                                        <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $url }}"
                                        target="_blank"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-black text-white hover:scale-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M18.244 2H21l-6.563 7.502L22 22h-6.828l-5.341-7.03L3.463 22H1l7.02-8.02L2 2h6.91l4.825 6.37L18.244 2z"/>
                                            </svg>
                                        </a>

                                        {{-- WhatsApp --}}
                                        <a href="#"
                                        onclick="shareWhatsApp(event)"
                                        target="_blank"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-[#25D366] text-white hover:scale-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M20.52 3.48A11.93 11.93 0 0012.04 0C5.43 0 .1 5.33.1 11.94c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.92 11.92 0 005.77 1.47h.01c6.61 0 11.94-5.33 11.94-11.94 0-3.19-1.24-6.19-3.47-8.41zM12.05 21.8h-.01a9.87 9.87 0 01-5.02-1.37l-.36-.21-3.72.97.99-3.63-.23-.37a9.87 9.87 0 01-1.51-5.24c0-5.46 4.45-9.9 9.91-9.9 2.65 0 5.14 1.03 7.01 2.91a9.84 9.84 0 012.89 7c0 5.46-4.45 9.9-9.91 9.9zm5.44-7.37c-.3-.15-1.76-.87-2.03-.97-.27-.1-.46-.15-.65.15-.2.3-.75.97-.92 1.17-.17.2-.34.22-.64.07-.3-.15-1.26-.46-2.4-1.46-.88-.79-1.48-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.34.45-.5.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.65-1.57-.9-2.15-.24-.57-.49-.5-.65-.51h-.55c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.06 2.87 1.21 3.07.15.2 2.08 3.17 5.05 4.45.7.3 1.25.48 1.68.62.7.22 1.33.19 1.83.12.56-.08 1.76-.72 2.01-1.41.25-.7.25-1.3.17-1.41-.07-.1-.27-.17-.57-.32z"/>
                                            </svg>
                                        </a>

                                        <!-- LinkedIn -->
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}"
                                        target="_blank"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-[#0A66C2] text-white hover:scale-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M4.98 3.5C4.98 4.88 3.86 6 2.49 6S0 4.88 0 3.5 1.12 1 2.49 1s2.49 1.12 2.49 2.5zM0 8h5v16H0V8zm7.5 0h4.78v2.16h.07c.67-1.27 2.3-2.6 4.73-2.6 5.06 0 6 3.33 6 7.66V24h-5v-7.84c0-1.87-.03-4.28-2.61-4.28-2.61 0-3.01 2.04-3.01 4.15V24h-5V8z"/>
                                            </svg>
                                        </a>

                                        <!-- Telegram -->
                                        <a href="https://t.me/share/url?url={{ $url }}&text={{ $title }}"
                                        target="_blank"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-[#229ED9] text-white hover:scale-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M9.993 15.674l-.4 4.326c.573 0 .822-.246 1.123-.54l2.694-2.577 5.586 4.09c1.024.563 1.75.267 2.004-.95l3.63-17.037c.337-1.56-.563-2.17-1.558-1.8L1.357 9.63c-1.516.592-1.495 1.44-.258 1.823l5.66 1.77 13.148-8.29c.62-.41 1.184-.183.72.227"/>
                                            </svg>
                                        </a>

                                        <!-- Email -->
                                        <a href="mailto:?subject={{ $title }}&body={{ $url }}"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-600 text-white hover:scale-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 13.065L.015 4.5A2 2 0 012 3h20a2 2 0 011.985 1.5L12 13.065zM0 6.697V19a2 2 0 002 2h20a2 2 0 002-2V6.697l-12 8.25L0 6.697z"/>
                                            </svg>
                                        </a>

                                    </div>
                                </div> 
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Blog box end -->

                @if ($post->comments)
                    <div class="comments-section sidebar-widget">
                        <div class="main-title-2"><h1>Comentários</h1></div>
                        <ul class="comments">                     
                            <li>
                                <div class="comment">
                                    <div class="comment-author"> 
                                        <?php
                                            $readUser = new Read;
                                            $readUser->ExeRead("usuario", "WHERE email = :emailId", "emailId={$coment['email']}");
                                            if($readUser->getResult()):
                                                $userComent = $readUser->getResult()['0'];
                                                echo '<a href="#">';
                                                echo '<img src="'.BASE.'/uploads/'.$userComent['avatar'].'" alt="'.$coment['nome'].'" />';
                                                echo '<a/>';
                                            else:
                                                $nomeComent = $coment['nome'];
                                                echo '<a href="#">';
                                                echo '<img src="'.PATCH.'/images/avatar.png" alt="'.$coment['nome'].'" />';
                                                echo '<a/>';
                                            endif;
                                        ?>                                
                                    </div>
                                    <div class="comment-content">
                                        <div class="comment-meta">
                                            <div class="comment-meta-author">
                                                <?= $coment['nome'];?>
                                            </div>
                                            <div class="comment-meta-reply">
                                                <a href="javascript:;" data-toggle="modal" data-target="#1">Responder</a>
                                            </div>
                                            <div class="comment-meta-date">
                                                <span class="hidden-xs"><?= date('d/m/Y', strtotime($coment['data']));?></span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="comment-body">
                                            <p><?= $coment['comentario'];?></p>
                                        </div>
                                    </div>
                                </div>

                                <ul>
                                    <li>
                                        <div class="comment">
                                            <div class="comment-author">
                                                <?php
                                                $readUser = new Read;
                                                $readUser->ExeRead("usuario", "WHERE email = :emailUser", "emailUser={$comentarioresp['email']}");
                                                if($readUser->getResult()):
                                                        $userComent = $readUser->getResult()['0'];
                                                        echo '<a href="#">';
                                                        echo '<img src="'.BASE.'/uploads/'.$userComent['avatar'].'" alt="'.$userComent['nome'].'"/>';
                                                        echo '<a/>';
                                                else:
                                                        echo '<a href="#">';
                                                        echo '<img src="'.PATCH.'/images/avatar.png" alt="'.$comentarioresp['nome'].'"/>';
                                                        echo '<a/>';
                                                endif;
                                                ?> 
                                            </div>

                                            <div class="comment-content">
                                                <div class="comment-meta">
                                                    <div class="comment-meta-author">
                                                        <?= $comentarioresp['nome'];?>
                                                    </div>
                                                    
                                                    <div class="comment-meta-date">
                                                        <span class="hidden-xs"><?= date('d/m/Y', strtotime($comentarioresp['data']));?></span>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="comment-body">                    
                                                    <p><?= $comentarioresp['comentario'];?></p>
                                                </div>
                                            </div>
                                        </div>        
                                    </li>
                                </ul>              
                            </li>  
                        </ul>
                    </div>
                    <div class="contact-1 sidebar-widget">
                        <div class="main-title-2">
                            <h1>Deixe seu Comentário</h1>
                        </div>
                        <div class="contact-form">
                            <form  action="" method="post" class="j_formsubmitcomentario">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="alertas"></div>
                                    </div>                                
                                    <div class="form_hide">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group fullname">
                                            <input class="noclear" type="hidden" name="action" value="comentario" />
                                            <input class="noclear" type="hidden" name="post_id" value="<?= $id;?>" />
                                            <input type="hidden" class="noclear" name="bairro" value="" />
                                            <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                            <input type="text" name="nome" class="input-text" placeholder="Seu Nome"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group enter-email">
                                            <input type="email" name="email" class="input-text" placeholder="Seu E-mail"/>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
                                        <div class="form-group message">
                                            <textarea class="input-text" name="comentario" placeholder="Comentário"></textarea>
                                        </div>
                                    </div>                                
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group enter-email" style="text-align: right;">
                                            <button style="width: 100%;" type="submit" class="button-md button-theme" id="b_nome">Enviar Comentário</button>
                                        </div>
                                    </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            

            <div class="col-lg-4 col-md-4 col-xs-12 col-md-pull-8">
                <div class="sidebar">
                    @if($categorias->count())                          
                        <div class="sidebar-widget category-posts">
                            <div class="main-title-2">
                                <h1>Categorias</h1>
                            </div>
                            <ul class="list-unstyled list-cat">
                                @foreach($categorias as $categoria)
                                    <li>
                                        <a href="{{route('web.blog.category',[ 'slug' => $categoria->slug ])}}">{{$categoria->title}} </a> 
                                        <span>({{$categoria->countposts()}})  </span>
                                    </li>                   
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($postsMais->count())
                        <div class="sidebar-widget popular-posts">
                            <div class="main-title-2">
                                <h1>Mais Lidos</h1>
                            </div>
                            @foreach($postsMais as $maislidos)
                                <div class="flex items-start gap-4 mb-8">
                                    <div class="flex-shrink-0">
                                        <img class="w-24 h-24 object-cover rounded" src="{{$maislidos->cover()}}" alt="{{$maislidos->title}}">
                                    </div>
                                    @php
                                        $tipo = $maislidos->type == 'noticia' ? 'noticia' : 'artigo';
                                    @endphp
                                    <div class="flex-1">
                                        <h3 class="text-md font-semibold text-teal-400 hover:text-gray-400 transition">
                                            <a href="{{ route('web.blog.'.$tipo,['slug' => $maislidos->slug]) }}">{{$maislidos->title}}</a>
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $maislidos->created_at->format('d M, Y') }}</p>                                
                                    </div>
                                </div> 
                            @endforeach
                        </div>                       
                    @endif                    
                    
                    @if($postsTags->count())
                        <div class="sidebar-widget tags-box">
                        <div class="main-title-2"><h1>Tags</h1></div>                        
                            <ul class="tags">                            
                                @foreach($postsTags as $tags2)
                                    @php
                                        $array = explode(',', $tags2->tags);
                                    @endphp
                                    @php
                                        $tipo = $tags2->type == 'noticia' ? 'noticia' : 'artigo';
                                    @endphp
                                    @foreach($array as $tag)
                                        @php $tag = trim($tag); @endphp
                                        <li>
                                            <a href="{{ route('web.blog.'.$tipo,['slug' => $tags2->slug]) }}">{{ $tag }}</a>
                                        </li>
                                    @endforeach                      
                                @endforeach
                            </ul>
                        </div>  
                    @endif                   
                    
                    <div class="social-media sidebar-widget clearfix">
                        <div class="main-title-2">
                            <h1>Redes Sociais</h1>
                        </div>
                        <ul class="social-list">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox='gallery']", {
            Thumbs: {
            autoStart: true,
            },
        });
    </script>
    <script>
        function shareWhatsApp(event) {
            event.preventDefault();

            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(document.title);
            const message = text + " " + url;

            const isMobile = /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i.test(navigator.userAgent);

            const whatsappUrl = isMobile
                ? `https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}`
                : `https://web.whatsapp.com/send?text={{ $title }}%20{{ $url }}`;

            window.open(whatsappUrl, '_blank');
        }
    </script>
@endsection