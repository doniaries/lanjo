{{-- Filter Tabs Skeleton - Reusable component for filter tabs --}}
@props([
'count' => 4
])

<div class="flex justify-center gap-4 mb-12 overflow-x-auto pb-4 animate-pulse">
    @for ($i = 0; $i < $count; $i++)
        <div class="h-10 w-24 bg-gray-300 dark:bg-gray-700 rounded-full shrink-0">
</div>
@endfor
</div>