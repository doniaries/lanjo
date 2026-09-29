<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Daftar Usaha — e-Trans' }}</title>
    <meta name="description" content="Daftarkan usaha Anda ke e-Trans dan kelola transaksi lebih mudah." />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0d1117;
            --surface:   #161b22;
            --surface2:  #21262d;
            --border:    #30363d;
            --primary:   #f97316;
            --primary-h: #ea6c0a;
            --text:      #e6edf3;
            --muted:     #8b949e;
            --success:   #3fb950;
            --radius:    14px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background-image:
                radial-gradient(ellipse 80% 60% at 50% -10%, rgba(249,115,22,.18) 0%, transparent 70%);
        }

        .guest-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 100%;
            max-width: 520px;
            padding: 40px;
            box-shadow: 0 24px 64px rgba(0,0,0,.5);
        }
    </style>

    @livewireStyles
</head>
<body>
    <div class="guest-card">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
