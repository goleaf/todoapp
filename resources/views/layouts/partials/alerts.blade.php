@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
         class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
        <strong class="font-bold">{{ __('Success!') }}</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <x-heroicon-s-x-mark @click="show = false" class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" />
        </span>
    </div>
@endif

@if (session('error') || session('status') && session('status') !== session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
        <strong class="font-bold">{{ __('Error!') }}</strong>
        <span class="block sm:inline">{{ session('error') ?? session('status') }}</span>
         <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <x-heroicon-s-x-mark @click="show = false" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" />
        </span>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show"
         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
        <strong class="font-bold">{{ __('Oops! Something went wrong.') }}</strong>
        <span class="block sm:inline">{{ __('Please check the form below for errors.') }}</span>
         <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <x-heroicon-s-x-mark @click="show = false" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" />
        </span>
        <ul class="mt-3 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 