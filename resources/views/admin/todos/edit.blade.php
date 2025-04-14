<x-layout.app>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin - Edit Todo') }}: {{ $todo->title }}
            </h2>
            <x-ui.button 
                href="{{ route('admin.todos.index') }}" 
                variant="secondary" 
                icon="heroicon-s-arrow-left"
            >
                {{ __('Back to Todos') }}
            </x-ui.button>
        </div>
    </x-slot>

    <x-ui.card withBorder>
        <x-slot name="header">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('Todo Details') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Update the details for this task.') }}</p>
        </x-slot>
        
        <form method="POST" action="{{ route('admin.todos.update', $todo) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- User --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('User')" for="user_id" :error="$errors->first('user_id')">
                            <x-input.select id="user_id" name="user_id" required :invalid="$errors->has('user_id')">
                                <option value="">{{ __('Select a user') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $todo->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                    {{-- Title --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('Title')" for="title" :error="$errors->first('title')">
                            <x-input.input 
                                type="text" 
                                name="title" 
                                id="title" 
                                :value="old('title', $todo->title)" 
                                required 
                                autofocus 
                                :invalid="$errors->has('title')" 
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Description --}}
                     <div class="col-span-full">
                        <x-input.form.group 
                            :label="__('Description')" 
                            for="description" 
                            :error="$errors->first('description')" 
                            helpText="Write a few sentences about the task."
                        >
                            <x-input.textarea 
                                id="description" 
                                name="description" 
                                :invalid="$errors->has('description')"
                                :value="old('description', $todo->description)"
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Status --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('Status')" for="status" :error="$errors->first('status')">
                            <x-input.select id="status" name="status" :invalid="$errors->has('status')">
                                <option value="">{{ __('Select status') }}</option>
                                <option value="pending" {{ old('status', $todo->status?->value) == 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="completed" {{ old('status', $todo->status?->value) == 'completed' ? 'selected' : '' }}>
                                    {{ __('Completed') }}
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
                    {{ __('Cancel') }}
                </x-ui.button>
                <x-ui.button 
                    type="submit" 
                    variant="primary" 
                    icon="heroicon-o-arrow-path"
                >
                    {{ __('Update Todo') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layout.app>
