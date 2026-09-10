@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-racing uppercase tracking-wider text-lg text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
