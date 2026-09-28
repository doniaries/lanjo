@props([
'title' => null,
])

@php
// Generate title from URL segments if not provided
if (!$title) {
$segments = request()->segments();
$title = end($segments) ?: 'Beranda';
$title = str_replace('-', ' ', $title);
$title = ucwords($title);

// Handle empty segments (homepage)
if (empty($title)) {
$title = 'Beranda';
}
}
@endphp

<!-- Page Header with Dynamic Animation -->
<div class="page-header relative overflow-hidden flex items-center justify-center bg-slate-900 border-b border-white/10 group" style="min-height: 140px; padding: 2rem 0;">
    <!-- dynamic background -->
    <div class="absolute inset-0 w-full h-full overflow-hidden z-0">
        <!-- Faster Moving Blobs -->
        <div class="absolute top-[-50%] left-[-20%] w-[80%] h-[200%] bg-blue-600/20 rounded-full blur-[80px] animate-blob mix-blend-screen"></div>
        <div class="absolute top-[-20%] right-[-20%] w-[70%] h-[180%] bg-cyan-500/20 rounded-full blur-[80px] animate-blob animation-delay-2000 mix-blend-screen"></div>
        <div class="absolute bottom-[-50%] left-[20%] w-[80%] h-[180%] bg-indigo-600/20 rounded-full blur-[80px] animate-blob animation-delay-4000 mix-blend-screen"></div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBMMDQwIDAiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgb3BhY2l0eT0iMC4wMyIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')] opacity-20 z-10"></div>

        <!-- Moving Particles (Fireflies) -->
        <div class="particles absolute inset-0 z-10">
            <div class="particle w-1 h-1 bg-white rounded-full absolute text-white" style="top: 20%; left: 20%; animation: particle-float 8s infinite ease-in-out;"></div>
            <div class="particle w-1.5 h-1.5 bg-blue-400 rounded-full absolute text-white" style="top: 70%; left: 80%; animation: particle-float 12s infinite ease-in-out 1s;"></div>
            <div class="particle w-1 h-1 bg-cyan-300 rounded-full absolute text-white opacity-80" style="top: 40%; left: 60%; animation: particle-float 10s infinite ease-in-out 2s;"></div>
            <div class="particle w-2 h-2 bg-indigo-400 rounded-full absolute text-white opacity-60" style="top: 80%; left: 10%; animation: particle-float 15s infinite ease-in-out 3s;"></div>
            <div class="particle w-1 h-1 bg-white rounded-full absolute text-white" style="top: 30%; left: 90%; animation: particle-float 9s infinite ease-in-out 1.5s;"></div>
        </div>

        <!-- Scrolling Wave Effect -->
        <div class="absolute bottom-0 left-0 right-0 z-20 overflow-hidden h-12">
            <div class="wave-container w-[200%] h-full absolute bottom-0 flex animate-wave">
                <svg class="w-1/2 h-full text-white/5" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47,24.64,98.5,46,155.3,53.29,66.8,8.23,133.8-1,200.7-19.66,66.7-19.33,133.6-46.33,200.6-59.54,67.1-12.8,133.2-12.2,201.2,2.75,67.1,14.65,133.3,42.55,200.3,56.8S1098,90,1200,80V0Z" fill="currentColor"></path>
                </svg>
                <svg class="w-1/2 h-full text-white/5" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47,24.64,98.5,46,155.3,53.29,66.8,8.23,133.8-1,200.7-19.66,66.7-19.33,133.6-46.33,200.6-59.54,67.1-12.8,133.2-12.2,201.2,2.75,67.1,14.65,133.3,42.55,200.3,56.8S1098,90,1200,80V0Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 relative z-30 text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight text-white drop-shadow-lg transform transition-transform duration-700 hover:scale-105">
            {{ $title }}
        </h1>
        <div class="mt-3 h-1.5 w-24 mx-auto bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full opacity-80 animate-pulse"></div>
    </div>
</div>

<style>
    /* Blob Animation */
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }

        33% {
            transform: translate(50px, -60px) scale(1.2);
        }

        66% {
            transform: translate(-30px, 30px) scale(0.85);
        }

        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }

    .animate-blob {
        animation: blob 8s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
        /* Faster animation */
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }

    /* Particle Animation */
    @keyframes particle-float {

        0%,
        100% {
            transform: translate(0, 0);
            opacity: 0;
        }

        25% {
            opacity: 0.8;
        }

        50% {
            transform: translate(20px, -40px);
            opacity: 0.4;
        }

        75% {
            opacity: 0.8;
        }
    }

    /* Wave Animation */
    @keyframes wave-scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .animate-wave {
        animation: wave-scroll 15s linear infinite;
    }
</style>