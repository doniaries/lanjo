<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Sijunjung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body
    class="bg-gray-900 text-white font-sans antialiased flex items-center justify-center min-h-screen overflow-hidden relative selection:bg-blue-500 selection:text-white">

    <!-- Background decoration -->
    <div class="absolute inset-0 z-0 opacity-30 pointer-events-none">
        <div
            class="absolute top-10 left-10 w-72 h-72 bg-blue-600 rounded-full mix-blend-multiply filter blur-[100px] animate-blob space-y-4">
        </div>
        <div
            class="absolute top-0 right-20 w-72 h-72 bg-purple-600 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-40 w-72 h-72 bg-pink-600 rounded-full mix-blend-multiply filter blur-[100px] animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="z-10 text-center px-4 max-w-2xl mx-auto flex flex-col items-center w-full">

        <!-- Animated Code -->
        <div class="floating mb-4 relative w-full flex items-center justify-center animate__animated animate__zoomIn">
            <h1
                class="text-[8rem] md:text-[12rem] font-black text-transparent bg-clip-text bg-linear-to-r from-blue-400 to-purple-500 drop-shadow-2xl leading-none tracking-tighter">
                @yield('code')
            </h1>
        </div>

        <h2
            class="text-3xl md:text-5xl font-bold mb-4 animate__animated animate__fadeInUp animate__delay-1s drop-shadow-md">
            @yield('message')
        </h2>

        <p class="text-gray-400 text-lg mb-10 animate__animated animate__fadeInUp animate__delay-1s max-w-lg mx-auto">
            @yield('description', 'Maaf, sepertinya telah terjadi kesalahan atau status layanan sedang tidak normal. Silakan coba beberapa saat lagi.')
        </p>

        <a href="{{ url('/') }}"
            class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-300 bg-blue-600/80 backdrop-blur-md border border-blue-500/50 rounded-full hover:bg-blue-600 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 animate__animated animate__fadeInUp animate__delay-2s shadow-[0_0_20px_rgba(37,99,235,0.4)] hover:shadow-[0_0_30px_rgba(37,99,235,0.6)]">
            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Beranda
        </a>

    </div>
</body>

</html>
