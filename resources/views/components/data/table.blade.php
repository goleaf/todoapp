@props(['head' => null, 'foot' => null])

<div {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-300 dark:divide-gray-700']) }}>
    <table class="min-w-full">
        @if(isset($header))
            <thead>
                <tr>
                    {{ $header }}
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            {{ $slot }}
        </tbody>
        @if(isset($footer))
            <tfoot>
                <tr>
                    {{ $footer }}
                </tr>
            </tfoot>
        @endif
    </table>
</div> 