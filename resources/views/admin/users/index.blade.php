<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin - Manage Users') }}
            </h2>
             {{-- Optional: Add Create User button if needed --}}
            {{-- <a href="{{ route('admin.users.create') }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                 {{-- <x-ui.icon icon="heroicon-s-plus" class="w-5 h-5 mr-1.5 -ml-0.5" /> --}}
                {{ __('Add New User') }}
            </a> --}}
        </div>
    </x-slot>

    {{-- Optional Filters --}}
    {{-- @include('admin.users.partials.filters') --}}

    {{-- User List Table --}}
    <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <x-data.table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 sm:pl-6">{{ __('ID') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Name') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Email') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Email Verified') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Registered') }}</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-6">{{ $user->id }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center rounded-md bg-green-50 dark:bg-green-400/10 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20 dark:ring-green-400/20" title="{{ $user->email_verified_at->translatedFormat('Y-m-d H:i:s') }}">
                                            {{ __('Verified') }}
                                        </span>
                                    @else
                                         <span class="inline-flex items-center rounded-md bg-yellow-50 dark:bg-yellow-400/10 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-500 ring-1 ring-inset ring-yellow-600/20 dark:ring-yellow-400/20">
                                            {{ __('Not Verified') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400" title="{{ $user->created_at->translatedFormat('Y-m-d H:i:s') }}">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex space-x-3 justify-end">
                                         {{-- Assuming admin routes like admin.users.show, admin.users.edit, etc. exist --}}
                                        {{-- <x-ui.link href="{{ route('admin.users.show', $user) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-200">{{ __('View') }}</x-ui.link> --}}
                                        <x-ui.link href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-200">{{ __('Edit') }}</x-ui.link>
                                        {{-- Add Delete form if needed --}}
                                        @if(auth()->id() !== $user->id)
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200" onclick="return confirm('{{ __('Are you sure you want to delete this user?') }}')">{{ __('Delete') }}</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-data.table>
            </div>
            
            {{-- Pagination --}}
             @if ($users->hasPages())
                 <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <x-data.pagination :paginator="$users" />
                </div>
             @endif
        @else
            {{-- Empty State --}}
             <div class="text-center px-4 py-12 sm:p-16">
                 {{-- <x-ui.icon icon="heroicon-o-users" class="mx-auto h-12 w-12 text-gray-400" /> --}}
                <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('No users found') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('There are currently no users in the system.') }}</p>
                 {{-- Optional: Add Create User button if needed --}}
                {{-- <div class="mt-6">
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                         {{-- <x-ui.icon icon="heroicon-s-plus" class="w-5 h-5 mr-1.5 -ml-0.5" /> --}}
                        {{ __('Add New User') }}
                    </a>
                </div> --}}
            </div>
        @endif
    </div>
</x-layout.app>
