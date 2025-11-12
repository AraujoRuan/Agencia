<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Créditos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Saldo de Créditos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="text-center">
                        <div class="mx-auto h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-3xl">💰</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Seu Saldo de Créditos</h3>
                        <p class="text-4xl font-bold text-blue-600 mb-4">{{ Auth::user()->credits }} créditos</p>
                        <p class="text-gray-600">Use seus créditos para destacar seus anúncios e alcançar mais compradores.</p>
                    </div>
                </div>
            </div>

            <!-- Planos Disponíveis -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Planos de Créditos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Plano Básico -->
                        <div class="border border-gray-200 rounded-lg p-6 text-center">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Plano Básico</h4>
                            <p class="text-3xl font-bold text-blue-600 mb-4">R$ 49,90</p>
                            <p class="text-2xl font-bold text-gray-900 mb-4">100 créditos</p>
                            <ul class="text-sm text-gray-600 mb-6 space-y-2">
                                <li>✅ Anúncios básicos</li>
                                <li>✅ 5 fotos por anúncio</li>
                                <li>✅ Suporte por email</li>
                            </ul>
                            <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                                Comprar Agora
                            </button>
                        </div>

                        <!-- Plano Profissional -->
                        <div class="border-2 border-blue-500 rounded-lg p-6 text-center relative">
                            <span class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">Mais Popular</span>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Plano Profissional</h4>
                            <p class="text-3xl font-bold text-blue-600 mb-4">R$ 99,90</p>
                            <p class="text-2xl font-bold text-gray-900 mb-4">250 créditos</p>
                            <ul class="text-sm text-gray-600 mb-6 space-y-2">
                                <li>✅ Anúncios destacados</li>
                                <li>✅ 10 fotos por anúncio</li>
                                <li>✅ Suporte prioritário</li>
                                <li>✅ Relatórios básicos</li>
                            </ul>
                            <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                                Comprar Agora
                            </button>
                        </div>

                        <!-- Plano Empresarial -->
                        <div class="border border-gray-200 rounded-lg p-6 text-center">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Plano Empresarial</h4>
                            <p class="text-3xl font-bold text-blue-600 mb-4">R$ 199,90</p>
                            <p class="text-2xl font-bold text-gray-900 mb-4">600 créditos</p>
                            <ul class="text-sm text-gray-600 mb-6 space-y-2">
                                <li>✅ Anúncios em destaque</li>
                                <li>✅ Fotos ilimitadas</li>
                                <li>✅ Relatórios avançados</li>
                                <li>✅ Suporte dedicado</li>
                                <li>✅ API access</li>
                            </ul>
                            <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                                Comprar Agora
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Como Usar Créditos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Como Usar Seus Créditos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-blue-600">⭐</span>
                                </div>
                                <h4 class="font-semibold">Destacar Anúncio</h4>
                            </div>
                            <p class="text-sm text-gray-600">Destaque seu anúncio por 7 dias para aparecer no topo das buscas.</p>
                            <p class="text-lg font-bold text-blue-600 mt-2">50 créditos</p>
                        </div>

                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-purple-600">🎨</span>
                                </div>
                                <h4 class="font-semibold">Realçar Anúncio</h4>
                            </div>
                            <p class="text-sm text-gray-600">Realce seu anúncio com cores especiais para chamar mais atenção.</p>
                            <p class="text-lg font-bold text-purple-600 mt-2">30 créditos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>