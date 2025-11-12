<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Veículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('vehicles.update', $vehicle->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Informações Básicas -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Informações Básicas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Título -->
                                    <div class="md:col-span-2">
                                        <x-input-label for="title" :value="__('Título do Anúncio *')" />
                                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $vehicle->title)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                    </div>

                                    <!-- Marca -->
                                    <div>
                                        <x-input-label for="brand" :value="__('Marca *')" />
                                        <select id="brand" name="brand" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione a marca</option>
                                            <option value="Volkswagen" {{ old('brand', $vehicle->brand) == 'Volkswagen' ? 'selected' : '' }}>Volkswagen</option>
                                            <option value="Fiat" {{ old('brand', $vehicle->brand) == 'Fiat' ? 'selected' : '' }}>Fiat</option>
                                            <option value="Ford" {{ old('brand', $vehicle->brand) == 'Ford' ? 'selected' : '' }}>Ford</option>
                                            <option value="Chevrolet" {{ old('brand', $vehicle->brand) == 'Chevrolet' ? 'selected' : '' }}>Chevrolet</option>
                                            <option value="Toyota" {{ old('brand', $vehicle->brand) == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                            <option value="Honda" {{ old('brand', $vehicle->brand) == 'Honda' ? 'selected' : '' }}>Honda</option>
                                            <option value="Hyundai" {{ old('brand', $vehicle->brand) == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                            <option value="Renault" {{ old('brand', $vehicle->brand) == 'Renault' ? 'selected' : '' }}>Renault</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('brand')" />
                                    </div>

                                    <!-- Modelo -->
                                    <div>
                                        <x-input-label for="model" :value="__('Modelo *')" />
                                        <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model', $vehicle->model)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('model')" />
                                    </div>

                                    <!-- Ano -->
                                    <div>
                                        <x-input-label for="year" :value="__('Ano *')" />
                                        <select id="year" name="year" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione o ano</option>
                                            @for($i = date('Y') + 1; $i >= 1990; $i--)
                                                <option value="{{ $i }}" {{ old('year', $vehicle->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('year')" />
                                    </div>

                                    <!-- Preço -->
                                    <div>
                                        <x-input-label for="price" :value="__('Preço (R$) *')" />
                                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price', $vehicle->price)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Detalhes do Veículo -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Detalhes do Veículo</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Quilometragem -->
                                    <div>
                                        <x-input-label for="mileage" :value="__('Quilometragem *')" />
                                        <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" :value="old('mileage', $vehicle->mileage)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('mileage')" />
                                    </div>

                                    <!-- Combustível -->
                                    <div>
                                        <x-input-label for="fuel_type" :value="__('Combustível *')" />
                                        <select id="fuel_type" name="fuel_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione o combustível</option>
                                            <option value="gasoline" {{ old('fuel_type', $vehicle->fuel_type) == 'gasoline' ? 'selected' : '' }}>Gasolina</option>
                                            <option value="ethanol" {{ old('fuel_type', $vehicle->fuel_type) == 'ethanol' ? 'selected' : '' }}>Álcool</option>
                                            <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                            <option value="electric" {{ old('fuel_type', $vehicle->fuel_type) == 'electric' ? 'selected' : '' }}>Elétrico</option>
                                            <option value="hybrid" {{ old('fuel_type', $vehicle->fuel_type) == 'hybrid' ? 'selected' : '' }}>Híbrido</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('fuel_type')" />
                                    </div>

                                    <!-- Câmbio -->
                                    <div>
                                        <x-input-label for="transmission" :value="__('Câmbio *')" />
                                        <select id="transmission" name="transmission" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione o câmbio</option>
                                            <option value="manual" {{ old('transmission', $vehicle->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                                            <option value="automatic" {{ old('transmission', $vehicle->transmission) == 'automatic' ? 'selected' : '' }}>Automático</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('transmission')" />
                                    </div>

                                    <!-- Cor -->
                                    <div>
                                        <x-input-label for="color" :value="__('Cor *')" />
                                        <x-text-input id="color" name="color" type="text" class="mt-1 block w-full" :value="old('color', $vehicle->color)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('color')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Localização -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Localização</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Estado -->
                                    <div>
                                        <x-input-label for="state" :value="__('Estado *')" />
                                        <select id="state" name="state" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione o estado</option>
                                            <option value="AC" {{ old('state', $vehicle->state) == 'AC' ? 'selected' : '' }}>Acre</option>
                                            <option value="AL" {{ old('state', $vehicle->state) == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                            <option value="AP" {{ old('state', $vehicle->state) == 'AP' ? 'selected' : '' }}>Amapá</option>
                                            <!-- ... outros estados ... -->
                                            <option value="SP" {{ old('state', $vehicle->state) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('state')" />
                                    </div>

                                    <!-- Cidade -->
                                    <div>
                                        <x-input-label for="city" :value="__('Cidade *')" />
                                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $vehicle->city)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Descrição</h3>
                                <div>
                                    <x-input-label for="description" :value="__('Descrição do Veículo *')" />
                                    <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $vehicle->description) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>
                            </div>

                            <!-- Imagens Atuais -->
                            @if($vehicle->images && count($vehicle->images) > 0)
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Imagens Atuais</h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($vehicle->images as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-32 object-cover rounded-lg">
                                        <div class="absolute bottom-2 left-2 right-2 text-center">
                                            <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">Atual</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Para alterar as imagens, selecione novas fotos abaixo.</p>
                            </div>
                            @endif

                            <!-- Novas Imagens -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Novas Imagens</h3>
                                <div>
                                    <x-input-label for="images" :value="__('Novas Fotos do Veículo')" />
                                    <input id="images" name="images[]" type="file" multiple accept="image/*" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <x-input-error class="mt-2" :messages="$errors->get('images')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('images.*')" />
                                    <p class="mt-1 text-sm text-gray-500">Selecione novas imagens para substituir as atuais.</p>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="flex justify-end space-x-4 pt-6 border-t">
                                <a href="{{ route('my-vehicles') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
                                    Cancelar
                                </a>
                                <x-primary-button>
                                    {{ __('Atualizar Anúncio') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>