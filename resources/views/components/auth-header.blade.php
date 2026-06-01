@props([
    'title',
    'description',
])

<div class="flex w-full flex-col">
    <h1 class="font-serif font-normal text-xl md:text-2xl tracking-tight text-brand-dark">{{ $title }}</h1>
    <p class="text-[15px] text-brand-text leading-relaxed mt-1.5">{{ $description }}</p>
</div>
