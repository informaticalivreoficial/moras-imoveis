@extends("web.$configuracoes->template.master.master")

@section('content')
<!-- Banner start -->
<div class="blog-banner">
    <div class="container">
        <div class="breadcrumb-area">
            <h1>Blog</h1>
            <ul class="breadcrumbs">
                <li><a href="{{route('web.home')}}">Início</a></li>
                <li class="active">Blog</li>
            </ul>
        </div>
    </div>
</div>
<!-- Banner end -->

<!-- Blog body start -->
<div class="blog-body content-area">
    <div class="container">
        <div class="row">
            @if($posts && $posts->count())
                <div class="row mb-40">
                    <div class="col-lg-12">                
                        <div class="alert alert-info wow fadeInRight delay-03s" role="alert" style="visibility: visible; animation-name: fadeInRight;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong>Desculpe!</strong> Não encontramos nenhum artigo publicado!
                        </div>                
                    </div>
                </div>
            @else       
                @foreach($posts as $art)
                    <div class="col-lg-4 col-md-4 col-sm-6 ">
                        <div class="thumbnail blog-box-2 clearfix" style="min-height: 470px;">
                            <div class="blog-photo">
                                <img src="{{$art->cover()}}" alt="{{$art->title}}" class="img-responsive">
                            </div>
                            @if ($art->autor)
                                <div class="post-meta">
                                    <ul>
                                        <li class="profile-user">
                                            <img src="{{$art->autor->url_avatar}}" alt="{{$art->autor->name}}">                                        
                                        </li>
                                        <li><span>{{$art->autor->name}}</span></li>
                                    </ul>
                                </div>
                            @endif
                            
                            <!-- Detail -->
                            <div class="caption detail">
                                <h4><a href="<?= BASE;?>/blog/artigo/<?= $url;?>">{{$art->title}}</a></h4>
                                <!-- paragraph -->
                                <?= Check::Words($content,20);?>
                                <div class="clearfix"></div>
                                <!-- Btn -->
                                <a href="<?= BASE;?>/blog/artigo/<?= $url;?>" class="read-more">Leia +</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            
            
            <div class="col-lg-12">
                <!-- Page navigation start -->
                <nav aria-label="Page navigation">
                    {{ $posts->links('vendor.pagination.default') }}
                </nav>
                <!-- Page navigation end -->
            </div>            
        </div>
    </div>
</div>
<!-- Blog body end -->
@endsection