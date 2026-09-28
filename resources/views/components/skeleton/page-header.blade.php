{{-- Page Header Skeleton - Reusable component for page headers --}}
@props([
'showSearch' => false,
'centered' => false
])

<div class="animate-pulse {{ $centered ? 'text-center' : 'flex flex-col md:flex-row justify-between items-center' }} mb-12">
    @if($centered)
    <div class="mb-12">
        <div class="h-10 bg-gray-300 dark:bg-gray-700 rounded w-1/3 mx-auto mb-4"></div>
        <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded w-1/2 mx-auto"></div>
    </div>
    @else
    <div class="mb-6 md:mb-0 w-full md:w-1/2">
        <div class="h-8 bg-gray-300 dark:bg-gray-700 rounded w-1/3 mb-2"></div>
        <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded w-1/2"></div>
    </div>
    @if($showSearch)
    <div class="w-full md:w-1/3">
        <div class="h-10 bg-gray-300 dark:bg-gray-700 rounded-full w-full"></div>
    </div>
    @endif
    @endif
</div>