<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PLN Prediction') }}</title>

    <link rel="icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        /*
         * Kelas utilitas untuk animasi fade-in saat halaman dimuat.
         */
        .starting-hidden {
            opacity: 0;
            transform: translateY(1rem);
        }

        /*
         * Perbaikan untuk style browser autofill yang menimpa desain.
         * Trik ini menggunakan box-shadow inset untuk "mewarnai" background.
         */
        /* Untuk Light Mode */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(255, 255, 255, 0.7) inset !important;
            -webkit-text-fill-color: #1f2937 !important; /* Warna teks gelap */
        }

        /* Untuk Dark Mode */
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover,
        .dark input:-webkit-autofill:focus,
        .dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(17, 24, 39, 0.7) inset !important;
            -webkit-text-fill-color: #e5e7eb !important; /* Warna teks terang */
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased overflow-hidden">
    
    <div class="flex flex-col items-center justify-center h-screen w-full p-4 bg-gradient-to-br from-white via-gray-50 to-blue-100 dark:from-black dark:via-gray-900 dark:to-[#0d1a26]">
        
        {{ $slot }}

    </div>

    <script>
        // Script untuk animasi staggered fade-in pada elemen
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.animate-on-load');
            elements.forEach((el, index) => {
                // Memberi jeda berdasarkan urutan elemen
                setTimeout(() => {
                    el.classList.remove('starting-hidden');
                }, 150 * (index + 1));
            });
        });
    </script>
</body>
</html>