<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Category') }}: {{ $category->name }}
            </h2>
            <div class="flex gap-2">
                <x-ui.button
                    href="{{ route('categories.show', $category) }}"
                    variant="secondary"
                    size="sm"
                    icon="heroicon-o-eye"
                >
                    {{ __('View Category') }}
                </x-ui.button>
                <x-ui.button
                    href="{{ route('categories.index') }}"
                    variant="secondary"
                    size="sm"
                    icon="heroicon-o-arrow-left"
                >
                    {{ __('Back to Categories') }}
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <x-ui.container>
        <div class="py-12">
            <div class="max-w-2xl mx-auto">
                <x-ui.card>
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <x-input.label for="name" :value="__('Name')" />
                                <x-input.input
                                    id="name"
                                    type="text"
                                    name="name"
                                    :value="old('name', $category->name)"
                                    required
                                    autofocus
                                    class="mt-1 block w-full"
                                />
                                <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input.label for="description" :value="__('Description')" />
                                <x-input.textarea
                                    id="description"
                                    name="description"
                                    class="mt-1 block w-full"
                                    :value="old('description', $category->description)"
                                    placeholder="{{ __('Optional description of this category') }}"
                                />
                                <x-input.input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Color -->
                            <div>
                                <x-input.label for="color" :value="__('Color')" />
                                <div class="flex mt-1">
                                    <input
                                        type="color"
                                        id="color"
                                        name="color"
                                        value="{{ old('color', $category->color) }}"
                                        class="h-10 w-16 rounded border border-gray-300 dark:border-gray-700"
                                    />
                                    <x-input.input
                                        type="text"
                                        id="color_hex"
                                        :value="old('color', $category->color)"
                                        class="ml-2 block w-full"
                                        placeholder="#HEX"
                                        readonly
                                    />
                                </div>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Choose a color to identify this category') }}
                                </p>
                                <x-input.input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-between">
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-ui.button
                                    type="submit"
                                    variant="danger"
                                    icon="heroicon-o-trash"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}')"
                                >
                                    {{ __('Delete Category') }}
                                </x-ui.button>
                            </form>
                            
                            <x-ui.button
                                type="submit"
                                variant="primary"
                                icon="heroicon-o-check"
                            >
                                {{ __('Update Category') }}
                            </x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </x-ui.container>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorInput = document.getElementById('color');
            const colorHexInput = document.getElementById('color_hex');

            // Update hex input when color changes
            colorInput.addEventListener('input', function() {
                colorHexInput.value = colorInput.value;
            });
        });
    </script>
    @endpush
</x-layout.app> 