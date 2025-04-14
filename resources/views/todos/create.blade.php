<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('todo.create_heading') }}
            </h2>
            <x-ui.button 
                href="{{ route('todos.index') }}" 
                variant="secondary" 
                icon="heroicon-s-arrow-left"
            >
                {{ __('todo.back_to_list') }}
            </x-ui.button>
        </div>
    </x-slot>

    <x-ui.card withBorder>
        <x-slot name="header">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('todo.details_heading') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('todo.details_subheading') }}</p>
        </x-slot>

        <form method="POST" action="{{ route('todos.store') }}">
            @csrf
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- Title --}}
                    <div class="sm:col-span-4">
                        <x-input.form.group :label="__('todo.title')" for="title" :error="$errors->first('title')">
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
                            :label="__('todo.description')" 
                            for="description" 
                            :error="$errors->first('description')" 
                            :helpText="__('todo.description_help')"
                        >
                            <x-input.textarea
                                id="description"
                                name="description"
                                :invalid="$errors->has('description')"
                                :value="old('description')"
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Category --}}
                     <div class="sm:col-span-3">
                        <x-input.form.group :label="__('todo.category')" for="category_id" :error="$errors->first('category_id')">
                            <x-input.select id="category_id" name="category_id" :invalid="$errors->has('category_id')">
                                <option value="">{{ __('todo.select_category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                     {{-- Parent Todo --}}
                    <div class="sm:col-span-3">
                        <x-input.form.group :label="__('todo.parent_todo')" for="parent_id" :error="$errors->first('parent_id')">
                            <x-input.select id="parent_id" name="parent_id" :invalid="$errors->has('parent_id')">
                                <option value="">{{ __('todo.parent_none') }}</option>
                                @foreach ($parentTodos as $todo)
                                    <option value="{{ $todo->id }}" {{ old('parent_id') == $todo->id ? 'selected' : '' }}>
                                        {{ $todo->title }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                     {{-- Due Date --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('todo.due_date')" for="due_date" :error="$errors->first('due_date')">
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
                        <x-input.form.group :label="__('todo.priority')" for="priority" :error="$errors->first('priority')">
                            <x-input.select id="priority" name="priority" required :invalid="$errors->has('priority')">
                                <option value="">{{ __('todo.select_priority') }}</option>
                                @foreach ($priorities as $key => $priority)
                                    <option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }}>
                                        {{ $priority }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                     {{-- Status --}}
                    <div class="sm:col-span-2">
                        <x-input.form.group :label="__('todo.status')" for="status" :error="$errors->first('status')">
                            <x-input.select id="status" name="status" :invalid="$errors->has('status')">
                                <option value="">{{ __('todo.select_status') }}</option>
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
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
                    {{ __('todo.cancel_button') }}
                </x-ui.button>
                <x-ui.button 
                    type="submit" 
                    variant="primary" 
                    icon="heroicon-o-check"
                >
                    {{ __('todo.create') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layout.app> 