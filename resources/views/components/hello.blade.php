{{-- @props(['hello'])
<div>
    <!-- Simplicity is the espsence of happiness. - Cedric Bledsoe -->
    <p {{ $attributes->merge(['class' => 'block font-medium text-lg text-red-700 dark:text-yellow-500']) }}>
        {{ $hello ?? $slot }}</p>
</div> --}}
@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
