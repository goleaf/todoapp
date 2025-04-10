<x-layout.app>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
             <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Todo') }}: {{ $todo->title }}
            </h2>
            <div class="flex items-center gap-x-3">
                <x-ui.button 
                    href="{{ route('todos.show', $todo) }}" 
                    variant="secondary" 
                    :icon="app('heroicon')->solid('eye')"
                >
                    {{ __('View Details') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ route('todos.index') }}" 
                    variant="secondary" 
                    :icon="app('heroicon')->solid('arrow-left')"
                >
                    {{ __('Back to Todos') }}
                </x-ui.button>
            </div>
        </div>
    </x-slot>

     <x-ui.card withBorder>
        <x-slot name="header">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('Todo Details') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Update the details for this task.') }}</p>
        </x-slot>
        
        <form method="POST" action="{{ route('todos.update', $todo) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- Title --}}
                    <div class="sm:col-span-4">
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
                            :helpText="__('Write a few sentences about the task.')"
                        >
                            <x-input.textarea
                                id="description"
                                name="description"
                                :invalid="$errors->has('description')"
                                :value="old('description', $todo->description)"
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Category --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('Category')" for="category_id" :error="$errors->first('category_id')">
                            <x-input.select id="category_id" name="category_id" :invalid="$errors->has('category_id')">
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $todo->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                    {{-- Parent Todo --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('Parent Todo')" for="parent_id" :error="$errors->first('parent_id')">
                            <x-input.select id="parent_id" name="parent_id" :invalid="$errors->has('parent_id')">
                                <option value="">{{ __('None (Top Level Todo)') }}</option>
                                @foreach ($parentTodos as $parentTodo)
                                    @if($parentTodo->id !== $todo->id)
                                        <option value="{{ $parentTodo->id }}" {{ old('parent_id', $todo->parent_id) == $parentTodo->id ? 'selected' : '' }}>
                                            {{ $parentTodo->title }}
                                        </option>
                                    @endif
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
                                :value="old('due_date', $todo->due_date?->format('Y-m-d'))" 
                                :invalid="$errors->has('due_date')" 
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Priority --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('Priority')" for="priority" :error="$errors->first('priority')">
                            <x-input.select id="priority" name="priority" required :invalid="$errors->has('priority')">
                                <option value="">{{ __('Select priority') }}</option>
                                @foreach ($priorities as $key => $priority)
                                    <option value="{{ $key }}" {{ old('priority', $todo->priority->value) == $key ? 'selected' : '' }}>
                                        {{ $priority }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                    {{-- Status --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('Status')" for="status" :error="$errors->first('status')">
                            <x-input.select id="status" name="status" :invalid="$errors->has('status')">
                                <option value="">{{ __('Select status') }}</option>
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}" {{ old('status', $todo->status->value) == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-ui.button href="{{ route('todos.show', $todo) }}" variant="secondary">
                    {{ __('Cancel') }}
                </x-ui.button>
                <x-ui.button 
                    type="submit" 
                    variant="primary" 
                    :icon="app('heroicon')->outline('check')"
                >
                    {{ __('Save Changes') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layout.app> 