<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Welcome') }}
        </h2>
    </x-slot>

    <div class="relative isolate overflow-hidden bg-gradient-to-b from-primary-100/20 pt-14">
      <div class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] bg-white dark:bg-gray-800 shadow-xl shadow-primary-600/10 ring-1 ring-primary-50 dark:ring-gray-700 sm:-mr-80 lg:-mr-96" aria-hidden="true"></div>
      <div class="mx-auto max-w-7xl px-6 py-32 sm:py-40 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8">
          <h1 class="max-w-2xl text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl lg:col-span-2 xl:col-auto">
            {{ __('Manage Your Tasks with Ease.') }}
          </h1>
          <div class="mt-6 max-w-xl lg:mt-0 xl:col-end-1 xl:row-start-1">
            <p class="text-lg leading-8 text-gray-600 dark:text-gray-300">
              {{ __('Organize your life, one task at a time. This application provides a simple and intuitive interface to keep track of your daily todos. Stay productive and focused.') }}
            </p>
            <div class="mt-10 flex items-center gap-x-6">
              @guest
                <a href="{{ route('login') }}" class="rounded-md bg-primary-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                    {{ __('Log in') }}
                    <span aria-hidden="true">→</span>
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                    {{ __('Register') }} <span aria-hidden="true">→</span>
                </a>
                @endif
              @else
                 <a href="{{ route('todos.index') }}" class="rounded-md bg-primary-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                    {{ __('Go to Todos') }}
                    <span aria-hidden="true">→</span>
                 </a>
              @endguest
            </div>
          </div>
           {{-- Optional: Add an image or illustration here --}}
          {{-- <img src="..." alt="" class="mt-10 aspect-[6/5] w-full max-w-lg rounded-2xl object-cover sm:mt-16 lg:mt-0 lg:max-w-none xl:row-span-2 xl:row-end-2 xl:mt-36"> --}}
        </div>
      </div>
      <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-white dark:from-gray-900 sm:h-32"></div>
    </div>

    {{-- Additional Sections (Example) --}}
    <div class="bg-white dark:bg-gray-800 py-24 sm:py-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
          <h2 class="text-base font-semibold leading-7 text-primary-600 dark:text-primary-400">{{ __('Features') }}</h2>
          <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">{{ __('Everything you need to stay organized') }}</p>
          <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
            {{ __('Focus on what matters most with these powerful features designed for productivity.') }}
          </p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
          <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
            <div class="flex flex-col">
              <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 flex-none text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.5 17a4.5 4.5 0 01-1.44-8.765 4.5 4.5 0 018.302-3.046 3.5 3.5 0 014.504 4.272A4 4 0 0115 17H5.5zm3.75-2.75a.75.75 0 001.5 0V9.66l1.95 2.1a.75.75 0 101.1-1.02l-3.25-3.5a.75.75 0 00-1.1 0l-3.25 3.5a.75.75 0 101.1 1.02l1.95-2.1v4.59z" clip-rule="evenodd" />
                </svg>
                {{ __('Task Management') }}
              </dt>
              <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                <p class="flex-auto">{{ __('Create, edit, categorize, prioritize, and mark tasks as complete. Simple and effective.') }}</p>
              </dd>
            </div>
            <div class="flex flex-col">
              <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 flex-none text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
                {{ __('Secure Authentication') }}
              </dt>
              <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                <p class="flex-auto">{{ __('Your tasks are private. Secure login and registration ensure only you can access your data.') }}</p>
              </dd>
            </div>
             <div class="flex flex-col">
              <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                <svg class="h-5 w-5 flex-none text-primary-600 dark:text-primary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                   <path d="M4.632 3.533A2 2 0 016.577 2.66l7.5 4.5A2 2 0 0114.077 11.2L6.577 15.74a2 2 0 01-1.945-.873L4.16 13.37a1 1 0 01.21-.906l4.25-4.25a.5.5 0 00-.707-.707l-4.25 4.25a1 1 0 01-1.414 0l-.434-.434a1 1 0 010-1.414l1.293-1.293a1 1 0 01.906-.21l2.434.47a2 2 0 011.38 1.38l.47 2.434a1 1 0 01-.21.906l-1.293 1.293a1 1 0 01-1.414 0l-.434-.434a1 1 0 010-1.414l.621-.621a.5.5 0 00-.707-.707l-.621.621a1 1 0 01-1.414 0l-.434-.434a1 1 0 010-1.414l1.293-1.293a1 1 0 01.906-.21l.47.095a2 2 0 011.88 1.88l.094.47a1 1 0 01-.21.906l-1.293 1.293a1 1 0 01-1.414 0z" />
                </svg>
                {{ __('Multilingual Support') }}
              </dt>
              <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                <p class="flex-auto">{{ __('Use the application in your preferred language. We support multiple languages for a global user base.') }}</p>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>

</x-app-layout>
