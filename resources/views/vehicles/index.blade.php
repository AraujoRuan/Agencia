<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comprar Veículos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('vehicles.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
                            <select id="brand" name="brand" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Todas as marcas</option>
                                <option value="Volkswagen" {{ request('brand') == 'Volkswagen' ? 'selected' : '' }}>Volkswagen</option>
                                <option value="Fiat" {{ request('brand') == 'Fiat' ? 'selected' : '' }}>Fiat</option>
                                <option value="Ford" {{ request('brand') == 'Ford' ? 'selected' : '' }}>Ford</option>
                                <option value="Chevrolet" {{ request('brand') == 'Chevrolet' ? 'selected' : '' }}>Chevrolet</option>
                            </select>
                        </div>

                        <div>
                            <label for="max_price" class="block text-sm font-medium text-gray-700">Preço Máximo</label>
                            <select id="max_price" name="max_price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Qualquer preço</option>
                                <option value="20000" {{ request('max_price') == '20000' ? 'selected' : '' }}>R$ 20.000</option>
                                <option value="40000" {{ request('max_price') == '40000' ? 'selected' : '' }}>R$ 40.000</option>
                                <option value="60000" {{ request('max_price') == '60000' ? 'selected' : '' }}>R$ 60.000</option>
                                <option value="80000" {{ request('max_price') == '80000' ? 'selected' : '' }}>R$ 80.000</option>
                            </select>
                        </div>

                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">Combustível</label>
                            <select id="fuel_type" name="fuel_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="gasoline" {{ request('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasolina</option>
                                <option value="ethanol" {{ request('fuel_type') == 'ethanol' ? 'selected' : '' }}>Álcool</option>
                                <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            </select>
                        </div>

                        <div class="md:col-span-3">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Aplicar Filtros
                            </button>
                            <a href="{{ route('vehicles.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">
                                Limpar Filtros
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Veículos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Veículos Encontrados</h3>
                        <span class="text-gray-600">{{ $vehicles->total() }} resultados</span>
                    </div>

                    @if($vehicles->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($vehicles as $vehicle)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                    <div class="relative">
                                        <img 
                                            src="{{ $vehicle->images && count($vehicle->images) > 0 ? asset('storage/' . $vehicle->images[0]) : '/placeholder-car.jpg' }}" 
                                            alt="{{ $vehicle->title }}"
                                            class="w-full h-48 object-cover"
                                        >
                                        @if($vehicle->is_featured)
                                            <div class="absolute top-2 left-2 bg-orange-500 text-white px-2 py-1 rounded text-xs">
                                                Destaque
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg mb-2">{{ $vehicle->title }}</h3>
                                        <p class="text-gray-600 text-sm mb-2">{{ $vehicle->year }} • {{ number_format($vehicle->mileage, 0, ',', '.') }} km • {{ $vehicle->fuel_type }}</p>
                                        <p class="text-gray-600 text-sm mb-4">{{ $vehicle->city }}, {{ $vehicle->state }}</p>
                                        
                                        <div class="flex justify-between items-center">
                                            <span class="text-xl font-bold text-blue-600">R$ {{ number_format($vehicle->price, 2, ',', '.') }}</span>
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                                                Ver Detalhes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginação -->
                        <div class="mt-6">
                            {{ $vehicles->links() }}
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            Nenhum veículo encontrado com os filtros selecionados.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>