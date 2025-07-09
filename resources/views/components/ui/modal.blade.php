@props([

    'id' => null,
    'name' => null,
    'title' => null,
    'closeButton' => true,
    'size' => 'md',
    'blur' => false,
    'closeOnEsc' => true,
    'closeOnClickOutside' => true,
    'dismissible' => true,
    'lazy_load' => false,
])

@php
    // Initialize required variables if they don't exist
    $attributes = $attributes ?? collect();
    $slot = $slot ?? '';
    $modalId = $modalId ?? '';
    $sizeCss = $sizeCss ?? '';
    $backdropClass = $backdropClass ?? '';
    
    // Get attributes from component service if not already set
    if (empty($modalId)) {
        $params = [
            'id' => $id ?? null,
            'size' => $size ?? 'md',
            'blur' => $blur ?? false,
        ];
        $attrs = app(\App\Services\BladeComponentService::class)->getModalAttributes($params);
        $modalId = $attrs['modalId'];
        $sizeCss = $attrs['sizeCss'];
        $backdropClass = $attrs['backdropClass'];
    }
@endphp

{{-- PHP logic moved to BladeComponentService --}}

@if ($lazy_load)
    <template id="modal-{{ $modalId }}-template">
        <div 
            x-data="{ 
                open: false,
                init() {
                    this.$nextTick(() => {
                        this.open = true;
                    });
                },
                close() {
                    this.open = false;
                    setTimeout(() => {
                        this.$el.remove();
                    }, 300);
                }
            }"
            x-on:keydown.escape.window="if({{ $closeOnEsc ? 'true' : 'false' }}) close()"
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50 {{ $backdropClass }}"
            x-cloak
        >
            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-4"
                @click.outside="if({{ $closeOnClickOutside ? 'true' : 'false' }}) close()"
                class="relative w-full {{ $sizeCss }} p-4 mx-auto my-8"
                x-cloak
            >
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                    @if($title || $closeButton)
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            @if($title)
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $title }}
                                </h3>
                            @else
                                <div></div>
                            @endif
                            
                            @if($closeButton)
                                <button 
                                    type="button"
                                    @click="close()"
                                    class="text-gray-400 hover:text-gray-500 focus:outline-none"
                                >
                                    <span class="sr-only">Close</span>
                                    @icon('heroicon-o-x-mark', 'h-6 w-6')
                                </button>
                            @endif
                        </div>
                    @endif
                    
                    <div class="px-4 py-5">
                        {{ $slot }}
                    </div>
                    
                    @if(isset($footer))
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-2">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </template>
    
    <div x-data="{ 
        openModal() {
            const template = document.getElementById('modal-{{ $modalId }}-template');
            const clone = template.content.cloneNode(true);
            document.body.appendChild(clone);
        }
    }">
        {{ $trigger }}
    </div>
    
@else
    <div 
        id="modal-{{ $modalId }}"
        x-data="{ 
            open: false,
            close() {
                this.open = false;
            }
        }"
        x-on:open-modal-{{ $name ?? $modalId }}.window="open = true"
        x-on:close-modal-{{ $name ?? $modalId }}.window="open = false"
        x-on:toggle-modal-{{ $name ?? $modalId }}.window="open = !open"
        x-on:keydown.escape.window="if({{ $closeOnEsc ? 'true' : 'false' }}) close()"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50 {{ $backdropClass }}"
        x-cloak
    >
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-4"
            @click.outside="if({{ $closeOnClickOutside ? 'true' : 'false' }}) close()"
            class="relative w-full {{ $sizeCss }} p-4 mx-auto my-8"
            x-cloak
        >
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                @if($title || $closeButton)
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        @if($title)
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $title }}
                            </h3>
                        @else
                            <div></div>
                        @endif
                        
                        @if($closeButton)
                            <button 
                                type="button"
                                @click="close()"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none"
                            >
                                <span class="sr-only">Close</span>
                                @icon('heroicon-o-x-mark', 'h-6 w-6')
                            </button>
                        @endif
                    </div>
                @endif
                
                <div class="px-4 py-5">
                    {{ $slot }}
                </div>
                
                @if(isset($footer))
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-2">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    {{ $trigger ?? '' }}
@endif 