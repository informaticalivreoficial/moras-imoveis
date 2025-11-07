<div>
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($properties as $property)
            <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">
                <img src="{{ $property->cover_url }}" alt="{{ $property->titulo }}" class="rounded-md w-full h-48 object-cover">
                <h3 class="text-lg font-semibold mt-3">{{ $property->titulo }}</h3>
                <p class="text-gray-600 text-sm">{{ $property->cidade }} - {{ $property->bairro }}</p>
                <p class="text-blue-600 font-bold mt-1">R$ {{ number_format($property->valor, 0, ',', '.') }}</p>
                <p class="text-gray-500 text-sm">{{ $property->dormitorios }} dorms</p>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center mt-8">Nenhum imóvel encontrado com esses filtros.</p>
        @endforelse
    </div>
</div>
