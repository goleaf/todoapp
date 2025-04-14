@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
         class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
        <strong class="font-bold">{{ __('Success!') }}</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <x-ui.icon icon="heroicon-s-x-mark" @click="show = false" class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" />
        </span>
    </div>
@endif

@if (session('error') || session('status') && session('status') !== session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
        <strong class="font-bold">{{ __('Error!') }}</strong>
        <span class="block sm:inline">{{ session('error') ?? session('status') }}</span>
         <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <x-ui.icon icon="heroicon-s-x-mark" @click="show = false" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" />
        </span>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show"
         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
        <strong class="font-bold">{{ __('Oops! Something went wrong.') }}</strong>
        <span class="block sm:inline">{{ __('Please check the form below for errors.') }}</span>
         <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <x-ui.icon icon="heroicon-s-x-mark" @click="show = false" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" />
        </span>
        <ul class="mt-3 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 mb-8 relative" role="alert">
    <div class="flex">
        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
        <div>
            <p class="font-bold">{{ session('status') }}</p>
        </div>
        <x-ui.icon icon="heroicon-s-x-mark" @click="show = false" class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" />
    </div>
</div>

<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 relative" role="alert">
    <div class="flex">
        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
        <div>
            @foreach (session('status_error') as $error)
            <p class="mb-2">{{ $error }}</p>
            @endforeach
        </div>
        <x-ui.icon icon="heroicon-s-x-mark" @click="show = false" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" />
    </div>
</div>

<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 relative" role="alert">
    <div class="flex">
        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
        <div>
            @foreach ($errors->all() as $error)
            <p class="mb-2">{{ $error }}</p>
            @endforeach
        </div>
        <x-ui.icon icon="heroicon-s-x-mark" @click="show = false" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" />
    </div>
</div> 