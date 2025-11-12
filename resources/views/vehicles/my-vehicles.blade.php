<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Anúncios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Botão para novo anúncio -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Meus Veículos Anunciados</h3>
                    <p class="text-gray-600">Gerencie seus anúncios de veículos</p>
                </div>
                <a href="{{ route('criar.anuncio') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                + Novo Anúncio
               </a>
               <a href="{{ route('criar.anuncio') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                Criar Primeiro Anúncio
                </a>
            </div>

            @if($vehicles->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($vehicles as $vehicle)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                    <div class="relative">
                                        <img 
                                            src="{{ $vehicle->images && count($vehicle->images) > 0 ? asset('storage/' . $vehicle->images[0]) : '/placeholder-car.jpg' }}" 
                                            alt="{{ $vehicle->title }}"
                                            class="w-full h-48 object-cover"
                                        >
                                        <div class="absolute top-2 left-2 flex space-x-1">
                                            @if($vehicle->is_featured)
                                                <span class="bg-orange-500 text-white px-2 py-1 rounded text-xs">Destaque</span>
                                            @endif
                                            @if($vehicle->is_highlighted)
                                                <span class="bg-purple-500 text-white px-2 py-1 rounded text-xs">Realçado</span>
                                            @endif
                                        </div>
                                        <div class="absolute top-2 right-2">
                                            <span class="bg-{{ $vehicle->is_active ? 'green' : 'red' }}-500 text-white px-2 py-1 rounded text-xs">
                                                {{ $vehicle->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg mb-2">{{ $vehicle->title }}</h3>
                                        <p class="text-gray-600 text-sm mb-2">
                                            {{ $vehicle->year }} • {{ number_format($vehicle->mileage, 0, ',', '.') }} km • {{ $vehicle->fuel_type }}
                                        </p>
                                        <p class="text-gray-600 text-sm mb-4">{{ $vehicle->city }}, {{ $vehicle->state }}</p>
                                        
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-xl font-bold text-blue-600">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</span>
                                        </div>

                                        <div class="flex justify-between items-center text-sm text-gray-500">
                                            <span>Visualizações: {{ $vehicle->view_count }}</span>
                                            <span>{{ $vehicle->created_at->format('d/m/Y') }}</span>
                                        </div>

                                        <!-- Ações -->
                                        <div class="mt-4 flex space-x-2">
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}" 
                                               class="flex-1 bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 text-sm">
                                                Ver
                                            </a>
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" 
                                               class="flex-1 bg-green-600 text-white text-center py-2 rounded hover:bg-green-700 text-sm">
                                                Editar
                                            </a>
                                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 text-sm"
                                                        onclick="return confirm('Tem certeza que deseja excluir este anúncio?')">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginação -->
                        <div class="mt-6">
                            {{ $vehicles->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum anúncio encontrado</h3>
                        <p class="text-gray-600 mb-6">Você ainda não possui veículos anunciados.</p>
                        <a href="{{ route('vehicles.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                            Criar Primeiro Anúncio
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>