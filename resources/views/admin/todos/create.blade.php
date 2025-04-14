<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('admin_todos.create_new_todo') }}
            </h2>
            <x-ui.button 
                href="{{ route('admin.todos.index') }}" 
                variant="secondary" 
                icon="heroicon-s-arrow-left"
            >
                {{ __('admin_todos.back_to_todos') }}
            </x-ui.button>
        </div>
    </x-slot>

    <x-ui.card withBorder>
        <x-slot name="header">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('admin_todos.todo_details') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('admin_todos.fill_details') }}</p>
        </x-slot>
        
        <form method="POST" action="{{ route('admin.todos.store') }}">
            @csrf
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- User --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('form.user')" for="user_id" :error="$errors->first('user_id')">
                            <x-input.select id="user_id" name="user_id" required :invalid="$errors->has('user_id')">
                                <option value="">{{ __('admin_todos.select_user') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                    {{-- Title --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('form.title')" for="title" :error="$errors->first('title')">
                            <x-input.input 
                                type="text" 
                                name="title" 
                                id="title" 
                                :value="old('title')" 
                                required 
                                autofocus 
                                :invalid="$errors->has('title')" 
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Description --}}
                    <div class="col-span-full">
                        <x-input.form.group 
                            :label="__('form.description')" 
                            for="description" 
                            :error="$errors->first('description')" 
                            helpText="Write a few sentences about the task."
                        >
                            <x-input.textarea
                                id="description"
                                name="description"
                                :invalid="$errors->has('description')"
                                :value="old('description')"
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Status --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('form.status')" for="status" :error="$errors->first('status')">
                            <x-input.select id="status" name="status" :invalid="$errors->has('status')">
                                <option value="">{{ __('admin_todos.select_status') }}</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                    {{ __('admin_todos.pending') }}
                                </option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                    {{ __('admin_todos.completed') }}
                                </option>
                            </x-input.select>
                        </x-input.form.group>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-ui.button 
                    href="{{ route('admin.todos.index') }}" 
                    variant="secondary"
                >
                    {{ __('admin_todos.cancel') }}
                </x-ui.button>
                <x-ui.button 
                    type="submit" 
                    variant="primary" 
                    icon="heroicon-o-check-circle"
                >
                    {{ __('admin_todos.create_todo') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layout.app>
