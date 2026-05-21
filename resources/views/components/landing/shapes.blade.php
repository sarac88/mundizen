{{--
    Componente de formas decorativas reutilizables.

    Uso:  <x-landing.shapes type="blob-sage" class="absolute top-10 left-20 w-40 h-40" />

    Regla de posicionamiento:
      - Los cortes solo deben ocurrir en las ESQUINAS de la sección
        (parecen intencionales). Evitar cortes en mitad de un borde.
      - Para esto: usar offsets negativos solo cuando la forma queda
        anclada a una esquina (p.ej. -top-10 -left-16), o usar offsets
        positivos para que la forma esté totalmente dentro de la sección.

    Tipos disponibles (fondo claro):
      - blob-sage / blob-sand / blob-coral / blob-sky
      - circles-sage / circles-sand
      - leaf-sage / drop-coral
      - dots-sand / wave-sage

    Tipos para fondos oscuros (mismas formas, tonos cream/lime):
      - circles-cream / dots-cream / wave-lime / leaf-lime
--}}

@props(['type' => 'blob-sage'])

@switch($type)
    @case('blob-sage')
        <svg {{ $attributes }} viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M44.7,-58.4C57.3,-49.3,66.6,-34.8,71.3,-18.5C76,-2.2,76,15.9,68.4,30.1C60.9,44.3,45.7,54.6,29.8,61.4C13.9,68.2,-2.8,71.5,-19.4,68C-36,64.5,-52.6,54.2,-62.9,39.3C-73.2,24.4,-77.2,4.9,-73.5,-12.7C-69.8,-30.4,-58.5,-46.2,-44.1,-55.6C-29.6,-65,-12,-67.9,2.7,-71.3C17.4,-74.7,32.1,-67.5,44.7,-58.4Z" transform="translate(100 100)" fill="#E8F0E4"/>
        </svg>
        @break

    @case('blob-sand')
        <svg {{ $attributes }} viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M38.5,-52.3C50.1,-44.6,59.7,-32.4,64.2,-18.3C68.7,-4.2,68.1,11.8,62.1,25.4C56.1,39,44.6,50.2,31,56.7C17.4,63.1,1.6,64.9,-13.8,61.6C-29.1,58.3,-44,49.9,-54.4,37.4C-64.7,24.9,-70.5,8.3,-68.8,-7.4C-67.1,-23.2,-57.9,-38.1,-45.3,-46.1C-32.7,-54.1,-16.4,-55.1,-1,-53.7C14.4,-52.3,26.8,-60,38.5,-52.3Z" transform="translate(100 100)" fill="#F5E8D8"/>
        </svg>
        @break

    @case('blob-coral')
        <svg {{ $attributes }} viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M42.8,-62.1C54.3,-53.7,61.3,-39.5,66.4,-24.6C71.5,-9.7,74.7,5.9,70.3,19.2C65.9,32.5,53.9,43.5,40.4,52.8C26.9,62.1,11.9,69.8,-3.6,74.5C-19.1,79.2,-38.2,80.9,-50.7,72.2C-63.2,63.5,-69.1,44.4,-71.8,26.5C-74.5,8.6,-74,-8.1,-67.7,-21.6C-61.4,-35.1,-49.3,-45.4,-36.4,-54.2C-23.5,-63,-9.8,-70.3,3.3,-74.8C16.4,-79.3,31.3,-70.5,42.8,-62.1Z" transform="translate(100 100)" fill="#F0E1DE"/>
        </svg>
        @break

    @case('blob-sky')
        <svg {{ $attributes }} viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M48.3,-65.1C61.2,-54.4,69.1,-38.4,72.6,-21.6C76.1,-4.8,75.1,12.8,68.8,28C62.5,43.2,50.8,55.9,36.6,63.2C22.4,70.5,5.8,72.4,-10.6,70.6C-27,68.8,-43.2,63.4,-54.7,52.3C-66.2,41.2,-73,24.3,-74.5,6.7C-76,-10.9,-72.1,-29.2,-61.8,-41.6C-51.5,-54,-34.8,-60.5,-19.1,-65C-3.4,-69.5,11.3,-72,25.1,-72C38.9,-72,52.7,-69.6,48.3,-65.1Z" transform="translate(100 100)" fill="#E5EDEE"/>
        </svg>
        @break

    @case('circles-sage')
        <svg {{ $attributes }} viewBox="0 0 100 100" aria-hidden="true">
            <circle cx="50" cy="50" r="45" fill="none" stroke="#7BA888" stroke-width="0.8" opacity="0.4"/>
            <circle cx="50" cy="50" r="32" fill="none" stroke="#7BA888" stroke-width="0.8" opacity="0.5"/>
            <circle cx="50" cy="50" r="18" fill="none" stroke="#7BA888" stroke-width="0.8" opacity="0.6"/>
        </svg>
        @break

    @case('circles-sand')
        <svg {{ $attributes }} viewBox="0 0 100 100" aria-hidden="true">
            <circle cx="50" cy="50" r="45" fill="none" stroke="#C9A876" stroke-width="0.8" opacity="0.4"/>
            <circle cx="50" cy="50" r="32" fill="none" stroke="#C9A876" stroke-width="0.8" opacity="0.5"/>
            <circle cx="50" cy="50" r="18" fill="none" stroke="#C9A876" stroke-width="0.8" opacity="0.6"/>
        </svg>
        @break

    @case('leaf-sage')
        <svg {{ $attributes }} viewBox="0 0 100 100" aria-hidden="true">
            <path d="M50 10 Q 85 30 75 65 Q 50 95 25 65 Q 15 30 50 10 Z" fill="none" stroke="#7BA888" stroke-width="1" opacity="0.5"/>
            <path d="M50 20 Q 50 60 50 85" stroke="#7BA888" stroke-width="0.8" opacity="0.4" fill="none"/>
        </svg>
        @break

    @case('drop-coral')
        <svg {{ $attributes }} viewBox="0 0 100 100" aria-hidden="true">
            <path d="M30 50 Q 50 15 70 50 Q 50 85 30 50 Z" fill="none" stroke="#B88478" stroke-width="1" opacity="0.45"/>
        </svg>
        @break

    @case('dots-sand')
        <svg {{ $attributes }} viewBox="0 0 80 80" aria-hidden="true">
            <g fill="#D4C4A8" opacity="0.7">
                @foreach ([6,26,46,66] as $y)
                    @foreach ([6,26,46,66] as $x)
                        <circle cx="{{ $x }}" cy="{{ $y }}" r="1.6"/>
                    @endforeach
                @endforeach
            </g>
        </svg>
        @break

    @case('wave-sage')
        <svg {{ $attributes }} viewBox="0 0 120 60" aria-hidden="true">
            <path d="M0 30 Q 20 10 40 30 T 80 30 T 120 30" fill="none" stroke="#7BA888" stroke-width="1.2" opacity="0.4"/>
            <path d="M0 40 Q 20 20 40 40 T 80 40 T 120 40" fill="none" stroke="#7BA888" stroke-width="1.2" opacity="0.3"/>
        </svg>
        @break

    {{-- ===== Variantes para fondos oscuros ===== --}}

    @case('circles-cream')
        <svg {{ $attributes }} viewBox="0 0 100 100" aria-hidden="true">
            <circle cx="50" cy="50" r="45" fill="none" stroke="#FBFAF6" stroke-width="0.8" opacity="0.25"/>
            <circle cx="50" cy="50" r="32" fill="none" stroke="#FBFAF6" stroke-width="0.8" opacity="0.35"/>
            <circle cx="50" cy="50" r="18" fill="none" stroke="#FBFAF6" stroke-width="0.8" opacity="0.45"/>
        </svg>
        @break

    @case('dots-cream')
        <svg {{ $attributes }} viewBox="0 0 80 80" aria-hidden="true">
            <g fill="#FBFAF6" opacity="0.35">
                @foreach ([6,26,46,66] as $y)
                    @foreach ([6,26,46,66] as $x)
                        <circle cx="{{ $x }}" cy="{{ $y }}" r="1.6"/>
                    @endforeach
                @endforeach
            </g>
        </svg>
        @break

    @case('wave-lime')
        <svg {{ $attributes }} viewBox="0 0 120 60" aria-hidden="true">
            <path d="M0 30 Q 20 10 40 30 T 80 30 T 120 30" fill="none" stroke="#c8e59c" stroke-width="1.2" opacity="0.35"/>
            <path d="M0 40 Q 20 20 40 40 T 80 40 T 120 40" fill="none" stroke="#c8e59c" stroke-width="1.2" opacity="0.25"/>
        </svg>
        @break

    @case('leaf-lime')
        <svg {{ $attributes }} viewBox="0 0 100 100" aria-hidden="true">
            <path d="M50 10 Q 85 30 75 65 Q 50 95 25 65 Q 15 30 50 10 Z" fill="none" stroke="#c8e59c" stroke-width="1" opacity="0.35"/>
            <path d="M50 20 Q 50 60 50 85" stroke="#c8e59c" stroke-width="0.8" opacity="0.3" fill="none"/>
        </svg>
        @break
@endswitch