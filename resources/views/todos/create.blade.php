<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Todo') }}
            </h2>
            <x-ui.button 
                href="{{ route('todos.index') }}" 
                variant="secondary" 
                :icon="app('heroicon')->solid('arrow-left')"
            >
                {{ __('Back to Todos') }}
            </x-ui.button>
        </div>
    </x-slot>

    <x-ui.card withBorder>
        <x-slot name="header">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('Todo Details') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Fill in the details for your new task.') }}</p>
        </x-slot>

        <form method="POST" action="{{ route('todos.store') }}">
            @csrf
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- Title --}}
                    <div class="sm:col-span-4">
                        <x-input.form.group :label="__('Title')" for="title" :error="$errors->first('title')">
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
                            :label="__('Description')" 
                            for="description" 
                            :error="$errors->first('description')" 
                            :helpText="__('Write a few sentences about the task.')"
                        >
                            <x-input.input.textarea 
                                id="description" 
                                name="description" 
                                rows="3" 
                                :value="old('description')" 
                                :invalid="$errors->has('description')" 
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Category --}}
                     <div class="sm:col-span-3">
                        <x-input.form.group :label="__('Category')" for="category_id" :error="$errors->first('category_id')">
                            <x-input.input.select id="category_id" name="category_id" :invalid="$errors->has('category_id')">
                                <option value="">{{ __('Select a category (optional)') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                     {{-- Parent Todo --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('Parent Todo')" for="parent_id" :error="$errors->first('parent_id')">
                            <x-input.input.select id="parent_id" name="parent_id" :invalid="$errors->has('parent_id')">
                                <option value="">{{ __('None (Top-level todo)') }}</option>
                                @foreach($parentTodos as $parentTodo)
                                    <option value="{{ $parentTodo->id }}" {{ old('parent_id') == $parentTodo->id ? 'selected' : '' }}>
                                        {{ $parentTodo->title }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                     {{-- Due Date --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('Due Date')" for="due_date" :error="$errors->first('due_date')">
                            <x-input.input 
                                type="date" 
                                name="due_date" 
                                id="due_date" 
                                :value="old('due_date')" 
                                :invalid="$errors->has('due_date')" 
                            />
                        </x-input.form.group>
                    </div>

                     {{-- Priority --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('Priority')" for="priority" :error="$errors->first('priority')">
                            <x-input.input.select id="priority" name="priority" required :invalid="$errors->has('priority')">
                                 @foreach (App\Enums\TodoPriority::cases() as $priority)
                                    <option value="{{ $priority->value }}" {{ old('priority', App\Enums\TodoPriority::MEDIUM->value) == $priority->value ? 'selected' : '' }}>{{ $priority->label() }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                     {{-- Status --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('Status')" for="status" :error="$errors->first('status')">
                            <x-input.input.select id="status" name="status" :invalid="$errors->has('status')">
                                 @foreach (App\Enums\TodoStatus::cases() as $status)
                                    <option value="{{ $status->value }}" {{ old('status', App\Enums\TodoStatus::PENDING->value) == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-ui.button 
                    href="{{ route('todos.index') }}" 
                    variant="secondary"
                >
                    {{ __('Cancel') }}
                </x-ui.button>
                <x-ui.button 
                    type="submit" 
                    variant="primary" 
                    :icon="app('heroicon')->outline('check')"
                >
                    {{ __('Create Todo') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layout.app> 