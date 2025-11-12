<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anunciar Veículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Informações Básicas -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Informações Básicas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Título -->
                                    <div class="md:col-span-2">
                                        <x-input-label for="title" :value="__('Título do Anúncio *')" />
                                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                                    </div>

                                    <!-- Marca -->
                                    <div>
                                        <x-input-label for="brand" :value="__('Marca *')" />
                                        <select id="brand" name="brand" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione a marca</option>
                                            <option value="Volkswagen" {{ old('brand') == 'Volkswagen' ? 'selected' : '' }}>Volkswagen</option>
                                            <option value="Fiat" {{ old('brand') == 'Fiat' ? 'selected' : '' }}>Fiat</option>
                                            <option value="Ford" {{ old('brand') == 'Ford' ? 'selected' : '' }}>Ford</option>
                                            <option value="Chevrolet" {{ old('brand') == 'Chevrolet' ? 'selected' : '' }}>Chevrolet</option>
                                            <option value="Toyota" {{ old('brand') == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                            <option value="Honda" {{ old('brand') == 'Honda' ? 'selected' : '' }}>Honda</option>
                                            <option value="Hyundai" {{ old('brand') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                                            <option value="Renault" {{ old('brand') == 'Renault' ? 'selected' : '' }}>Renault</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('brand')" />
                                    </div>

                                    <!-- Modelo -->
                                    <div>
                                        <x-input-label for="model" :value="__('Modelo *')" />
                                        <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model')" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('model')" />
                                    </div>

                                    <!-- Ano -->
                                    <div>
                                        <x-input-label for="year" :value="__('Ano *')" />
                                        <select id="year" name="year" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione o ano</option>
                                            @for($i = date('Y') + 1; $i >= 1990; $i--)
                                                <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('year')" />
                                    </div>

                                    <!-- Preço -->
                                    <div>
                                        <x-input-label for="price" :value="__('Preço (R$) *')" />
                                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price')" required />
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
                                        <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" :value="old('mileage')" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('mileage')" />
                                    </div>

                                    <!-- Combustível -->
                                    <div>
                                        <x-input-label for="fuel_type" :value="__('Combustível *')" />
                                        <select id="fuel_type" name="fuel_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione o combustível</option>
                                            <option value="gasoline" {{ old('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasolina</option>
                                            <option value="ethanol" {{ old('fuel_type') == 'ethanol' ? 'selected' : '' }}>Álcool</option>
                                            <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                            <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Elétrico</option>
                                            <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Híbrido</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('fuel_type')" />
                                    </div>

                                    <!-- Câmbio -->
                                    <div>
                                        <x-input-label for="transmission" :value="__('Câmbio *')" />
                                        <select id="transmission" name="transmission" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Selecione o câmbio</option>
                                            <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                            <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automático</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('transmission')" />
                                    </div>

                                    <!-- Cor -->
                                    <div>
                                        <x-input-label for="color" :value="__('Cor *')" />
                                        <x-text-input id="color" name="color" type="text" class="mt-1 block w-full" :value="old('color')" required />
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
                                            <option value="AC" {{ old('state') == 'AC' ? 'selected' : '' }}>Acre</option>
                                            <option value="AL" {{ old('state') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                            <option value="AP" {{ old('state') == 'AP' ? 'selected' : '' }}>Amapá</option>
                                            <option value="AM" {{ old('state') == 'AM' ? 'selected' : '' }}>Amazonas</option>
                                            <option value="BA" {{ old('state') == 'BA' ? 'selected' : '' }}>Bahia</option>
                                            <option value="CE" {{ old('state') == 'CE' ? 'selected' : '' }}>Ceará</option>
                                            <option value="DF" {{ old('state') == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                            <option value="ES" {{ old('state') == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                            <option value="GO" {{ old('state') == 'GO' ? 'selected' : '' }}>Goiás</option>
                                            <option value="MA" {{ old('state') == 'MA' ? 'selected' : '' }}>Maranhão</option>
                                            <option value="MT" {{ old('state') == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                            <option value="MS" {{ old('state') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                            <option value="MG" {{ old('state') == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                            <option value="PA" {{ old('state') == 'PA' ? 'selected' : '' }}>Pará</option>
                                            <option value="PB" {{ old('state') == 'PB' ? 'selected' : '' }}>Paraíba</option>
                                            <option value="PR" {{ old('state') == 'PR' ? 'selected' : '' }}>Paraná</option>
                                            <option value="PE" {{ old('state') == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                            <option value="PI" {{ old('state') == 'PI' ? 'selected' : '' }}>Piauí</option>
                                            <option value="RJ" {{ old('state') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                            <option value="RN" {{ old('state') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                            <option value="RS" {{ old('state') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                            <option value="RO" {{ old('state') == 'RO' ? 'selected' : '' }}>Rondônia</option>
                                            <option value="RR" {{ old('state') == 'RR' ? 'selected' : '' }}>Roraima</option>
                                            <option value="SC" {{ old('state') == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                            <option value="SP" {{ old('state') == 'SP' ? 'selected' : '' }}>São Paulo</option>
                                            <option value="SE" {{ old('state') == 'SE' ? 'selected' : '' }}>Sergipe</option>
                                            <option value="TO" {{ old('state') == 'TO' ? 'selected' : '' }}>Tocantins</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('state')" />
                                    </div>

                                    <!-- Cidade -->
                                    <div>
                                        <x-input-label for="city" :value="__('Cidade *')" />
                                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Descrição</h3>
                                <div>
                                    <x-input-label for="description" :value="__('Descrição do Veículo *')" />
                                    <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                    <p class="mt-1 text-sm text-gray-500">Descreva detalhes importantes sobre o veículo, estado de conservação, histórico de manutenção, etc.</p>
                                </div>
                            </div>

                            <!-- Imagens -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Imagens</h3>
                                <div>
                                    <x-input-label for="images" :value="__('Fotos do Veículo')" />
                                    <input id="images" name="images[]" type="file" multiple accept="image/*" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <x-input-error class="mt-2" :messages="$errors->get('images')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('images.*')" />
                                    <p class="mt-1 text-sm text-gray-500">Selecione até 10 imagens do veículo. A primeira imagem será a capa do anúncio.</p>
                                    
                                    <!-- Preview de imagens -->
                                    <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 hidden">
                                        <!-- As imagens preview serão inseridas aqui via JavaScript -->
                                    </div>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="flex justify-end space-x-4 pt-6 border-t">
                                <a href="{{ route('my-vehicles') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
                                    Cancelar
                                </a>
                                <x-primary-button>
                                    {{ __('Publicar Anúncio') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview de imagens
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            preview.classList.remove('hidden');

            const files = e.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                            <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs" onclick="this.parentElement.remove()">×</button>
                        `;
                        preview.appendChild(div);
                    }
                    
                    reader.readAsDataURL(file);
                }
            }
        });

        // Formatação de preço
        document.getElementById('price').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2);
            e.target.value = value;
        });

        // Formatação de quilometragem
        document.getElementById('mileage').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
</x-app-layout>