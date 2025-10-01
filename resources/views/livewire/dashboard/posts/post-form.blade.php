<div>
    @section('title', $titlee)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-home mr-2"></i> {{ $post->exists ? 'Editar Post' : 'Cadastrar Post' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
                        <li class="breadcrumb-item active">{{ $post->exists ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{
        tab: @entangle('currentTab'),
            init() {
                if (!this.tab) this.tab = 'dados';
            }
        }" class="w-full bg-white">
        <!-- Abas -->
        <div class="flex space-x-2 border-b border-green-300">
            <button type="button"
                    class="px-4 py-4 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'dados' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'dados'">
                📝 Dados
            </button>
            <button type="button"
                    class="px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'imagens' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'imagens'">
                📷 Imagens
            </button>
            <button type="button"
                    class="px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'seo' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'seo'">
                🔍 Seo
            </button>
        </div>


    </div>
</div>
