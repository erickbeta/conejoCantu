@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-brand-black border-brand-red/50 text-white focus:border-brand-red focus:ring-brand-red rounded-md shadow-[0_0_10px_rgba(230,32,32,0.2)]']) }}>
