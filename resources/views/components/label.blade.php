@props(['value'])

<label {{ $attributes->merge(['class' => 'text-right rtl block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
