{{-- Page Container Skeleton - Wrapper for skeleton pages --}}
@props([
'background' => 'bg-gray-50 dark:bg-gray-900'
])

<div class="py-12 {{ $background }} min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</div>