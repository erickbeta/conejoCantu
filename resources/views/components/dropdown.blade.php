@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-brand-dark border border-white/10'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<div class="relative custom-dropdown">
    <div class="dropdown-trigger cursor-pointer" onclick="
        let content = this.nextElementSibling;
        let isHidden = content.style.display === 'none' || content.style.display === '';
        // Cierra todos los demas primero
        document.querySelectorAll('.dropdown-content').forEach(el => el.style.display = 'none');
        // Abre este si estaba cerrado
        content.style.display = isHidden ? 'block' : 'none';
    ">
        {{ $trigger }}
    </div>

    <div class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} dropdown-content"
            style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

<script>
    // Cerrar el dropdown al hacer clic fuera
    if (!window.dropdownListenerAdded) {
        window.dropdownListenerAdded = true;
        document.addEventListener('click', function(event) {
            var dropdowns = document.querySelectorAll('.custom-dropdown');
            dropdowns.forEach(function(dropdown) {
                if (!dropdown.contains(event.target)) {
                    var content = dropdown.querySelector('.dropdown-content');
                    if (content) content.style.display = 'none';
                }
            });
        });
    }
</script>
