@props(['type' => 'success'])

@if(session($type))
    @php
        $bg = $type === 'success' ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900';
        $border = $type === 'success' ? 'border-green-400 dark:border-green-700' : 'border-red-400 dark:border-red-700';
        $text = $type === 'success' ? 'text-green-700 dark:text-green-100' : 'text-red-700 dark:text-red-100';
        $svgText = $type === 'success' ? 'text-green-500 dark:text-green-300' : 'text-red-500 dark:text-red-300';
    @endphp
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 mt-4">
        <div class="{{ $bg }} border {{ $border }} {{ $text }} px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session($type) }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                <svg class="fill-current h-6 w-6 {{ $svgText }}" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Cerrar</title>
                    <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652A1 1 0 105.652 7.066L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
                </svg>
            </button>
        </div>
    </div>
@endif
