<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Token') }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('tokens.show', $token) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Token
                </a>
                <a href="{{ route('tokens.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    Back to Tokens
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <!-- Information Banner -->
                    <div class="mb-8 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Editing Token: {{ $token->name }}</h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <p>Update your token settings. The token value itself will remain unchanged unless you regenerate it.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('tokens.update', $token) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Token Name -->
                        <div>
                            <x-input-label for="name" :value="__('Token Name')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <x-text-input id="name" 
                                        name="name" 
                                        type="text" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        :value="old('name', $token->name)" 
                                        required 
                                        autofocus 
                                        placeholder="e.g., My MCP Application" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">A descriptive name to help you identify this token.</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <textarea id="description" 
                                    name="description" 
                                    rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Describe what this token will be used for...">{{ old('description', $token->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional description to help you remember what this token is for.</p>
                        </div>

                        <!-- Permissions -->
                        <div>
                            <x-input-label for="permissions" :value="__('Permissions (Optional)')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <div class="mt-2 space-y-2">
                                <div class="flex items-center">
                                    <input id="read" name="permissions[]" type="checkbox" value="read" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" {{ in_array('read', old('permissions', $token->permissions ?? [])) ? 'checked' : '' }}>
                                    <label for="read" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Read access</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="write" name="permissions[]" type="checkbox" value="write" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" {{ in_array('write', old('permissions', $token->permissions ?? [])) ? 'checked' : '' }}>
                                    <label for="write" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Write access</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="execute" name="permissions[]" type="checkbox" value="execute" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" {{ in_array('execute', old('permissions', $token->permissions ?? [])) ? 'checked' : '' }}>
                                    <label for="execute" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Execute access</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="admin" name="permissions[]" type="checkbox" value="admin" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" {{ in_array('admin', old('permissions', $token->permissions ?? [])) ? 'checked' : '' }}>
                                    <label for="admin" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Admin access</label>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select the permissions this token should have. Leave empty for default permissions.</p>
                        </div>

                        <!-- Expiration Date -->
                        <div>
                            <x-input-label for="expires_at" :value="__('Expiration Date (Optional)')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                            <x-text-input id="expires_at" 
                                        name="expires_at" 
                                        type="datetime-local" 
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                        :value="old('expires_at', $token->expires_at ? $token->expires_at->format('Y-m-d\TH:i') : '')" 
                                        min="{{ now()->format('Y-m-d\TH:i') }}" />
                            <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">When should this token expire? Leave empty for no expiration.</p>
                        </div>

                        <!-- Quick Expiration Options -->
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quick expiration options:</p>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" 
                                        onclick="setExpiration(30)" 
                                        class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    30 days
                                </button>
                                <button type="button" 
                                        onclick="setExpiration(90)" 
                                        class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    90 days
                                </button>
                                <button type="button" 
                                        onclick="setExpiration(365)" 
                                        class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    1 year
                                </button>
                                <button type="button" 
                                        onclick="clearExpiration()" 
                                        class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    No expiration
                                </button>
                            </div>
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                       {{ old('is_active', $token->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Token is active</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Uncheck to deactivate this token without deleting it.</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('tokens.show', $token) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Cancel
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('Update Token') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setExpiration(days) {
            const date = new Date();
            date.setDate(date.getDate() + days);
            document.getElementById('expires_at').value = date.toISOString().slice(0, 16);
        }

        function clearExpiration() {
            document.getElementById('expires_at').value = '';
        }
    </script>
</x-app-layout> 