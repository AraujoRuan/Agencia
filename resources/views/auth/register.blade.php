<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nome completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Account Type -->
        <div class="mt-4">
            <x-input-label for="type" :value="__('Tipo de conta')" />
            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Selecione o tipo</option>
                <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>Pessoa Física</option>
                <option value="business" {{ old('type') == 'business' ? 'selected' : '' }}>Pessoa Jurídica</option>
            </select>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>

        <!-- Document (CPF/CNPJ) -->
        <div class="mt-4">
            <x-input-label for="document" :value="__('CPF/CNPJ')" />
            <x-text-input id="document" class="block mt-1 w-full" type="text" name="document" :value="old('document')" required placeholder="000.000.000-00" />
            <x-input-error :messages="$errors->get('document')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Telefone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required placeholder="(11) 99999-9999" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar senha')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Já está cadastrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Cadastrar') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const documentInput = document.getElementById('document');
            
            function updateDocumentPlaceholder() {
                if (typeSelect.value === 'business') {
                    documentInput.placeholder = '00.000.000/0000-00';
                } else {
                    documentInput.placeholder = '000.000.000-00';
                }
            }
            
            typeSelect.addEventListener('change', updateDocumentPlaceholder);
            updateDocumentPlaceholder(); // Initial call
        });
    </script>
</x-guest-layout>