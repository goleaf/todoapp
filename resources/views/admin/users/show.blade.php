<x-layout.app>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate" title="{{ $user->name }}">
                {{ __('Admin - User Details') }}: <span class="italic">{{ Str::limit($user->name, 50) }}</span>
            </h2>
            <div class="flex items-center gap-x-3">
                <x-ui.button 
                    href="{{ route('admin.users.edit', $user) }}" 
                    variant="warning" 
                    size="sm" 
                    :icon="app('heroicon')->outline('pencil-square')"
                >
                    {{ __('Edit') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ route('admin.users.index') }}" 
                    variant="secondary" 
                    size="sm" 
                    :icon="app('heroicon')->outline('arrow-left')"
                >
                    {{ __('Back to Users') }}
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <x-ui.card>
        {{-- User Details Section --}}
        <x-slot name="header">
            <h3 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">{{ __('Details for user ID:') }} {{ $user->id }}</p>
        </x-slot>
        
        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Full Name') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $user->name }}</dd>
            </div>
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Email Address') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $user->email }}</dd>
            </div>
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Email Verified') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-400/10 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20 dark:ring-green-400/20" title="{{ $user->email_verified_at->translatedFormat('Y-m-d H:i:s') }}">
                            <x-ui.icon.heroicon-s-check-circle class="w-4 h-4 mr-1 -ml-0.5" />
                            {{ __('Verified') }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-400/10 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-500 ring-1 ring-inset ring-yellow-600/20 dark:ring-yellow-400/20">
                            <x-ui.icon.heroicon-s-exclamation-circle class="w-4 h-4 mr-1 -ml-0.5" />
                            {{ __('Not Verified') }}
                        </span>
                    @endif
                </dd>
            </div>
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Registered') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0" title="{{ $user->created_at->translatedFormat('Y-m-d H:i:s') }}">
                    {{ $user->created_at->diffForHumans() }}
                </dd>
            </div>
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Last Updated') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0" title="{{ $user->updated_at->translatedFormat('Y-m-d H:i:s') }}">
                    {{ $user->updated_at->diffForHumans() }}
                </dd>
            </div>
            {{-- Optional: Display Roles if applicable --}}
            {{-- <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Roles') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">...</dd>
            </div> --}}
        </dl>
    </x-ui.card>

    {{-- User's Todos Section --}}
    <x-ui.card class="mt-6">
        <x-slot name="header">
            <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('User's Todos') }} ({{ $user->todos()->count() }})</h3>
        </x-slot>
        
        @if($user->todos()->count() > 0)
            {{-- Fetch recent or paginated todos for performance if needed --}}
            @php $userTodos = $user->todos()->latest()->limit(10)->get(); @endphp 
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 rounded-md border border-gray-200 dark:border-gray-700">
                @foreach($userTodos as $todo)
                    <li class="flex items-center justify-between gap-x-6 py-3 px-4 text-sm leading-6">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $todo->title }}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500 dark:text-gray-400">{{ __('Created') }}: {{ $todo->created_at->translatedFormat('Y-m-d') }}</p>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-x-4">
                            <span @class([
                                'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                                match ($todo->status) {
                                    App\Enums\TodoStatus::COMPLETED => 'bg-green-50 dark:bg-green-400/10 text-green-700 dark:text-green-400 ring-green-600/20 dark:ring-green-400/20',
                                    App\Enums\TodoStatus::IN_PROGRESS => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
                                    App\Enums\TodoStatus::PENDING => 'bg-gray-50 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400 ring-gray-500/10 dark:ring-gray-400/20',
                                }
                            ])>
                                {{ $todo->status->label() }}
                            </span>
                            <x-ui.button 
                                href="{{ route('admin.todos.show', $todo) }}" 
                                variant="secondary" 
                                size="xs" 
                                class="hidden sm:block"
                            >
                                {{ __('View Todo') }}<span class="sr-only">, {{ $todo->title }}</span>
                            </x-ui.button>
                        </div>
                    </li>
                @endforeach
                @if($user->todos()->count() > 10)
                    <li class="flex items-center justify-center gap-x-6 py-3 px-4 text-sm leading-6">
                        <a href="{{ route('admin.todos.index', ['user_id' => $user->id]) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-200 font-medium">{{ __('View all :count todos...', ['count' => $user->todos()->count()]) }}</a>
                    </li>
                @endif
            </ul>
        @else
            <div class="rounded-md bg-blue-50 dark:bg-blue-900/50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <x-ui.icon.heroicon-o-information-circle class="h-5 w-5 text-blue-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            {{ __('This user has no todos.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        <x-slot name="footer">
            <div class="flex items-center justify-between">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}')">
                    @csrf
                    @method('DELETE')
                    <x-ui.button 
                        type="submit" 
                        variant="danger" 
                        size="sm" 
                        :icon="app('heroicon')->outline('trash')" 
                        :disabled="$user->id === auth()->id()"
                    >
                        {{ __('Delete User') }}
                    </x-ui.button>
                    @if($user->id === auth()->id())
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('You cannot delete your own account.') }}</p>
                    @endif
                </form>
                <x-ui.button 
                    href="{{ route('admin.users.edit', $user) }}" 
                    variant="warning" 
                    size="sm" 
                    :icon="app('heroicon')->outline('pencil-square')"
                >
                    {{ __('Edit User') }}
                </x-ui.button>
            </div>
        </x-slot>
    </x-ui.card>
</x-layout.app> 