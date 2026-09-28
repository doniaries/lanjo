<div class="p-2 w-full" style="min-width: 300px; height: 320px;">
    @php
    $lat = $getRecord()->latitude;
    $lng = $getRecord()->longitude;
    $id = $getRecord()->id;
    @endphp

    @if($lat && $lng)
    <div
        x-data="{
                id: '{{ $id }}',
                lat: {{ $lat }},
                lng: {{ $lng }},
                map: null,
                init() {
                    this.checkLeaflet();
                },
                checkLeaflet() {
                    if (typeof L !== 'undefined') {
                        this.setupMap();
                    } else {
                        setTimeout(() => this.checkLeaflet(), 200);
                    }
                },
                setupMap() {
                    const container = document.getElementById('map-' + this.id);
                    if (!container || container._leaflet_id) return;

                    this.map = L.map('map-' + this.id, {
                        zoomControl: true,
                        attributionControl: false,
                        scrollWheelZoom: false
                    }).setView([this.lat, this.lng], 15);
                    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);
                    
                    L.marker([this.lat, this.lng]).addTo(this.map);
                    
                    // Progressive invalidation to handle all rendering stages
                    [100, 500, 1000, 2000].forEach(delay => {
                        setTimeout(() => this.map.invalidateSize(), delay);
                    });
                }
            }"
        id="map-{{ $id }}"
        class="w-full h-full bg-gray-200 dark:bg-gray-700 rounded-3xl border border-gray-300 dark:border-gray-600 shadow-lg overflow-hidden relative"
        style="min-height: 300px;"
        wire:ignore>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-xs text-gray-400 bg-gray-50 dark:bg-gray-900 z-0">
            <i class="bi bi-geo-alt-fill text-2xl mb-2 opacity-20"></i>
            Memuat Peta...
        </div>
    </div>
    @else
    <div class="w-full h-full min-h-[300px] rounded-3xl bg-gray-50 dark:bg-gray-800 flex flex-col items-center justify-center text-gray-400 text-sm italic border border-dashed border-gray-300 dark:border-gray-700">
        <i class="bi bi-geo-alt text-4xl mb-3 opacity-30"></i>
        Lokasi tidak tersedia
    </div>
    @endif
</div>

@once
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush
@endonce