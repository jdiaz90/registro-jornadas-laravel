@props([
    // Nombre de la definición de migas (opcional). Si se omite, se intenta inferir la ruta actual.
    'name' => null,
    // Parámetros necesarios para la definición, en caso de que la definición los requiera.
    'params' => []
])

@php
    // Genera las migas. Si se proporciona un 'name', se utiliza esa definición pasando los parámetros;
    // de lo contrario, se genera en función de la ruta actual.
    $breadcrumbs = $name 
        ? \Diglactic\Breadcrumbs\Breadcrumbs::generate($name, ...array_values($params))
        : \Diglactic\Breadcrumbs\Breadcrumbs::generate();
@endphp

@if($breadcrumbs->isNotEmpty())
    <nav aria-label="Breadcrumb" class="mt-4 ml-4" style="margin-left: 1rem;">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="inline-flex items-center">
                    @if(!$loop->first)
                        <!-- Icono de flecha para separar las migas -->
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    @endif

                    @if(!$loop->last && $breadcrumb->url)
                        <a href="{{ $breadcrumb->url }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            {{ $breadcrumb->title }}
                        </a>
                    @else
                        <span class="text-gray-500 text-sm font-medium">
                            {{ $breadcrumb->title }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
