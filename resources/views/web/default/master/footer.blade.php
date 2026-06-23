<footer class="bg-gray-900 text-gray-100 py-24">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8">
            <!-- Atendimento: ocupa mais espaço -->
            <div class="lg:col-span-5">
                <h2 class="text-md font-bold mb-5 text-gray-100">Atendimento</h2>
                <p class="mb-5 text-md text-gray-200">{{ $configuracoes->information }}</p>
                <ul class="space-y-4 text-md text-gray-200">
                    @if ($configuracoes->display_address)
                        <li class="flex items-start gap-2">
                            <i class="fa fa-map-marker mt-1"></i>
                            <span>
                                @if ($configuracoes->street) {{ $configuracoes->street }} @endif
                                @if ($configuracoes->number) , {{ $configuracoes->number }} @endif
                                @if ($configuracoes->neighborhood) , {{ $configuracoes->neighborhood }} @endif
                                @if ($configuracoes->city) - {{ $configuracoes->city }} @endif
                                @if ($configuracoes->state) / {{ $configuracoes->state }} @endif
                            </span>
                        </li>
                    @endif
                    @if ($configuracoes->email)
                        <li class="flex items-center gap-2">
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:{{$configuracoes->email}}" class="text-gray-200 hover:text-teal-400">{{ $configuracoes->email }}</a>
                        </li>
                    @endif
                    @if ($configuracoes->additional_email)
                        <li class="flex items-center gap-2">
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:{{$configuracoes->additional_email}}" class="text-gray-200 hover:text-teal-400">{{ $configuracoes->additional_email }}</a>
                        </li>
                    @endif
                    @if ($configuracoes->phone)
                        <li class="flex items-center gap-2">
                            <i class="fa fa-phone"></i>
                            <a href="tel:{{$configuracoes->phone}}" class="text-gray-200 hover:text-teal-400">{{ $configuracoes->phone }}</a>
                        </li>
                    @endif
                    @if ($configuracoes->cell_phone)
                        <li class="flex items-center gap-2">
                            <i class="fa fa-phone"></i>
                            <a href="tel:{{$configuracoes->cell_phone}}" class="text-gray-200 hover:text-teal-400">{{ $configuracoes->cell_phone }}</a>
                        </li>
                    @endif
                    @if ($configuracoes->whatsapp)
                        <li class="flex items-center gap-2">
                            <i class="fa fa-whatsapp"></i>
                            <a target="_blank" href="{{ \App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp, 'Atendimento '.$configuracoes->app_name) }}" class="text-gray-200 hover:text-teal-400">{{ $configuracoes->whatsapp }}</a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Links -->
            <div class="lg:col-span-3">
                <h2 class="text-md font-bold mb-5 text-gray-100">Links</h2>
                <ul class="space-y-2 text-md text-gray-200">
                    <li><a href="{{ route('web.home') }}" class="text-gray-200 hover:text-teal-400">Início</a></li>
                    <li><a href="{{ route('web.blog.index') }}" class="text-gray-200 hover:text-teal-400">Blog</a></li>
                    <li><a href="{{route('web.properties')}}" class="text-gray-200 hover:text-teal-400">Imóveis</a></li>
                    <li><a target="_blank" href="{{route('web.simulator')}}" class="text-gray-200 hover:text-teal-400">Financiamento</a></li>
                    <li><a href="{{route('web.pesquisar-imoveis')}}" class="text-gray-200 hover:text-teal-400">Buscar Imóvel</a></li>
                    @if (!empty($lancamentoMenu) && $lancamentoMenu->count() > 0)
                        <li><a class="text-gray-200 hover:text-teal-400" href="{{route('web.highliths')}}" title="Lançamentos">Lançamentos</a></li>
                    @endif
                    @if ($configuracoes->privacy_policy)
                        <li><a href="{{route('web.privacy')}}" class="text-gray-200 hover:text-teal-400">Política de Privacidade</a></li>                        
                    @endif
                    <li><a @click="openModal()" class="text-gray-200 hover:text-teal-400">Preferências de cookies</a></li>
                    <li><a href="{{route('web.contact')}}" class="text-gray-200 hover:text-teal-400">Atendimento</a></li>
                </ul>
            </div>

            <!-- Blog -->
            <div class="lg:col-span-4">
                <h2 class="text-md font-bold mb-5 text-gray-100">Blog</h2>
                <div class="space-y-8">
                    @if($postsfooter && $postsfooter->count())
                        @foreach($postsfooter as $blog)
                            @php
                                $tipo = $blog->type == 'noticia' ? 'noticia' : 'artigo';
                            @endphp
                            <div class="flex items-start gap-4 mb-8">
                                <div class="flex-shrink-0">
                                    <img src="{{ $blog->cover() }}" alt="{{ $blog->title }}" class="w-24 h-24 object-cover rounded">
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-md font-semibold text-teal-400 hover:text-gray-400 transition">
                                        <a href="{{ route('web.blog.'.$tipo,['slug' => $blog->slug]) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-300 mt-1">{{ $blog->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>