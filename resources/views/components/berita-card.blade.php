@props(['post'])

<div
    class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
    <!-- Featured Image Wrapper -->
    <div class="block shrink-0 relative overflow-hidden">
        <a wire:navigate href="{{ route('berita.show', $post->slug) }}" class="block w-full h-full">
            @if ($post->foto_utama)
                <img src="{{ $post->foto_utama_url }}" alt="{{ $post->title }}" loading="lazy"
                    class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110"
                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center\'><i class=\'bi bi-image text-gray-400 text-4xl\'></i></div>'">
            @else
                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                    <i class="bi bi-image text-gray-400 dark:text-gray-500 text-4xl"></i>
                </div>
            @endif

            <!-- Category Badge (Overlay) -->
            @if ($post->tags && $post->tags->count() > 0)
                <div class="absolute top-3 left-3 z-10 flex flex-wrap gap-1.5 pr-3">
                    @foreach ($post->tags as $tag)
                        @php
                            // Strictly vibrant 17-color fallback palette (No grays/slates)
                            $fallbackColors = [
                                '#ef4444',
                                '#f97316',
                                '#f59e0b',
                                '#eab308',
                                '#84cc16',
                                '#22c55e',
                                '#10b981',
                                '#14b8a6',
                                '#06b6d4',
                                '#0ea5e9',
                                '#3b82f6',
                                '#6366f1',
                                '#8b5cf6',
                                '#a855f7',
                                '#d946ef',
                                '#ec4899',
                                '#f43f5e',
                            ];

                            $baseColor = $tag->color;
                            if (empty($baseColor)) {
                                $colorIndex = $tag->id % count($fallbackColors);
                                $baseColor = $fallbackColors[$colorIndex];
                            }

                            $hex = str_replace('#', '', $baseColor);
                            $r = hexdec(substr($hex, 0, 2));
                            $g = hexdec(substr($hex, 2, 2));
                            $b = hexdec(substr($hex, 4, 2));
                            $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
                            $textColor = $brightness > 160 ? 'text-gray-900' : 'text-white';
                        @endphp
                        <span
                            class="inline-block px-2 py-1 text-xs font-semibold {{ $textColor }} rounded shadow-md backdrop-blur-sm"
                            style="background-color: {{ $baseColor }}">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </a>
    </div>

    <!-- Post Content -->
    <div class="p-5 flex flex-col grow">
        <!-- Title -->
        <div class="flex items-start justify-between gap-3 mb-2">
            <h2
                class="text-lg font-bold text-gray-900 dark:text-white leading-tight line-clamp-1 md:line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors flex-1 relative z-10">
                <a wire:navigate href="{{ route('berita.show', $post->slug) }}" class="block w-full">
                    {{ $post->title }}
                </a>
            </h2>
            <a wire:navigate href="{{ route('berita.show', $post->slug) }}"
                class="md:hidden shrink-0 bg-blue-600 hover:bg-blue-700 hover:-translate-y-0.5 hover:brightness-110 hover:shadow-xl hover:shadow-blue-500/40 text-white px-4 py-2 rounded-xl text-[10px] font-semibold shadow-md shadow-blue-500/20 transition-all duration-300 flex items-center gap-1.5 relative z-30 active:scale-95">
                Baca <i class="bi bi-arrow-right-short text-sm"></i>
            </a>
        </div>



        <!-- Excerpt -->
        <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 text-sm grow">
            {{ Str::limit(strip_tags($post->content), 100) }}
        </p>

        <!-- Date and Meta -->
        <div class="pt-4 mt-auto border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between gap-2 text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1">
                        <i class="bi bi-calendar3"></i>
                        {{ $post->published_at ? $post->published_at->format('d M Y') : 'N/A' }}
                    </span>
                    <span class="flex items-center gap-1" title="Penulis">
                        <i class="bi bi-person"></i>
                        {{ strtok($post->user->name ?? 'Admin', ' ') }}
                    </span>
                </div>

                @if (isset($post->views))
                    <span class="flex items-center gap-1" title="Dilihat">
                        <i class="bi bi-eye"></i>
                        {{ number_format($post->views, 0, ',', '.') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
