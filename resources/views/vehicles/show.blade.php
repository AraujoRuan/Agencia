<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Veículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($vehicle)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Imagens -->
                            <div>
                                <div class="mb-4">
                                    <img 
                                        src="{{ $vehicle->images && count($vehicle->images) > 0 ? asset('storage/' . $vehicle->images[0]) : '/placeholder-car.jpg' }}" 
                                        alt="{{ $vehicle->title }}"
                                        class="w-full h-80 object-cover rounded-lg"
                                    >
                                </div>
                                
                                @if($vehicle->images && count($vehicle->images) > 1)
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach($vehicle->images as $image)
                                            <img 
                                                src="{{ asset('storage/' . $image) }}" 
                                                alt="{{ $vehicle->title }}"
                                                class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75"
                                            >
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Informações -->
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">{{ $vehicle->title }}</h1>
                                        <p class="text-xl font-bold text-blue-600 mt-2">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if($vehicle->is_featured)
                                            <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-sm">Destaque</span>
                                        @endif
                                        @if($vehicle->is_highlighted)
                                            <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm">Realçado</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Detalhes -->
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="bg-gray-50 p-3 rounded">
                                        <p class="text-sm text-gray-600">Ano</p>
                                        <p class="font-semibold">{{ $vehicle->year }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded">
                                        <p class="text-sm text-gray-600">Quilometragem</p>
                                        <p class="font-semibold">{{ number_format($vehicle->mileage, 0, ',', '.') }} km</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded">
                                        <p class="text-sm text-gray-600">Combustível</p>
                                        <p class="font-semibold">
                                            @switch($vehicle->fuel_type)
                                                @case('gasoline') Gasolina @break
                                                @case('ethanol') Álcool @break
                                                @case('diesel') Diesel @break
                                                @case('electric') Elétrico @break
                                                @case('hybrid') Híbrido @break
                                                @default {{ $vehicle->fuel_type }}
                                            @endswitch
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded">
                                        <p class="text-sm text-gray-600">Câmbio</p>
                                        <p class="font-semibold">
                                            {{ $vehicle->transmission == 'automatic' ? 'Automático' : 'Manual' }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded">
                                        <p class="text-sm text-gray-600">Cor</p>
                                        <p class="font-semibold">{{ $vehicle->color }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded">
                                        <p class="text-sm text-gray-600">Visualizações</p>
                                        <p class="font-semibold">{{ $vehicle->view_count }}</p>
                                    </div>
                                </div>

                                <!-- Localização -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-2">Localização</h3>
                                    <p class="text-gray-700">{{ $vehicle->city }}, {{ $vehicle->state }}</p>
                                </div>

                                <!-- Descrição -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-2">Descrição</h3>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $vehicle->description }}</p>
                                </div>

                                <!-- Vendedor -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-semibold mb-3">Informações do Vendedor</h3>
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span class="text-lg font-semibold text-gray-600">
                                                {{ substr($vehicle->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $vehicle->user->name }}</p>
                                            <p class="text-sm text-gray-600">
                                                Membro desde {{ $vehicle->user->created_at->format('m/Y') }}
                                            </p>
                                            @if($vehicle->user->rating_count > 0)
                                                <p class="text-sm text-yellow-600">
                                                    ⭐ {{ number_format($vehicle->user->rating, 1) }} ({{ $vehicle->user->rating_count }} avaliações)
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Ações -->
                                @if(Auth::id() === $vehicle->user_id)
                                    <div class="mt-6 flex space-x-3">
                                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" 
                                           class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                                            Editar Anúncio
                                        </a>
                                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700"
                                                    onclick="return confirm('Tem certeza que deseja excluir este anúncio?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600">Veículo não encontrado.</p>
                            <a href="{{ route('vehicles.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Voltar para a lista de veículos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>