<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kasir - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#3b82f6">
    <link rel="apple-touch-icon" href="/images/icon-192x192.png">
    
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful in kasir layout');
                }).catch(function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' },
                        surface: { DEFAULT:'var(--surface)', card:'var(--surface-card)', border:'var(--surface-border)', muted:'var(--surface-muted)' },
                        main: 'var(--text-main)',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --surface: #f8fafc;
            --surface-card: #ffffff;
            --surface-border: #e2e8f0;
            --surface-muted: #64748b;
            --text-main: #0f172a;
        }
        .dark {
            --surface: #0f172a;
            --surface-card: #1e293b;
            --surface-border: #334155;
            --surface-muted: #475569;
            --text-main: #ffffff;
        }
        * { -webkit-tap-highlight-color: transparent; }
        body { color: var(--text-main); }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: var(--surface-card); }
        ::-webkit-scrollbar-thumb { background: var(--surface-border); border-radius: 99px; }
        .menu-card:active { transform: scale(0.97); }
        .btn-qty:active { transform: scale(0.9); }
        @keyframes slideIn { from { transform: translateX(100%); opacity:0; } to { transform: translateX(0); opacity:1; } }
        @keyframes fadeUp { from { transform: translateY(20px); opacity:0; } to { transform: translateY(0); opacity:1; } }
        .slide-in { animation: slideIn .25s ease-out; }
        .fade-up { animation: fadeUp .3s ease-out; }
    </style>
    @livewireStyles
</head>
<body class="h-full bg-surface font-sans overflow-hidden transition-colors duration-200">
    {{ $slot }}
    @livewireScripts
    <script>
        // Init theme on load
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        }
    </script>
</body>
</html>
