<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Card de Créditos -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <span class="text-2xl">💰</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-blue-800">Seus Créditos</h3>
                                    <p class="text-2xl font-bold text-blue-600">{{ Auth::user()->credits }}</p>
                                </div>
                            </div>
                            <a href="{{ route('my-credits') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Comprar mais créditos →
                            </a>
                        </div>

                        <!-- Card de Anúncios -->
                        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <span class="text-2xl">🚗</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-green-800">Meus Anúncios</h3>
                                    <p class="text-2xl font-bold text-green-600">{{ Auth::user()->vehicles->count() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('my-vehicles') }}" class="mt-4 inline-block text-green-600 hover:text-green-800 text-sm font-medium">
                                Gerenciar anúncios →
                            </a>
                        </div>

                        <!-- Card de Avaliação -->
                        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <span class="text-2xl">⭐</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-purple-800">Sua Avaliação</h3>
                                    <p class="text-2xl font-bold text-purple-600">{{ number_format(Auth::user()->rating, 1) }}/5.0</p>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-purple-600">{{ Auth::user()->rating_count }} avaliações</p>
                        </div>
                    </div>

                    <!-- Informações da Conta -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Informações da Conta</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nome</p>
                                <p class="font-medium">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ Auth::user()->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tipo de Conta</p>
                                <p class="font-medium">{{ Auth::user()->type == 'individual' ? 'Pessoa Física' : 'Pessoa Jurídica' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Documento</p>
                                <p class="font-medium">{{ Auth::user()->document }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Telefone</p>
                                <p class="font-medium">{{ Auth::user()->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Membro desde</p>
                                <p class="font-medium">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>