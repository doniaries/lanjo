{{-- Card Grid Skeleton - Reusable component for grid layouts --}}
@props([
'count' => 6,
'columns' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
'showImage' => true,
'imageHeight' => 'h-48'
])

<div class="grid {{ $columns }} gap-8">
    @for ($i = 0; $i < $count; $i++)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden h-full flex flex-col animate-pulse">
        @if($showImage)
        <div class="{{ $imageHeight }} bg-gray-300 dark:bg-gray-700 w-full"></div>
        @endif
        <div class="p-6 flex-1 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded w-1/3"></div>
                <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded w-1/4"></div>
            </div>
            <div class="h-6 bg-gray-300 dark:bg-gray-700 rounded w-3/4 mb-3"></div>
            <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded w-full mb-2"></div>
            <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded w-2/3"></div>
        </div>
</div>
@endfor
</div>