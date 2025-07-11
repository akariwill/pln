<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>PLN Prediction - Prediksi Beban Listrik</title>

        <link rel="icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <style type="text/tailwindcss">
            @layer utilities {
                .bg-grid-pattern {
                    background-image: linear-gradient(rgba(0, 123, 255, 0.07) 1px, transparent 1px), linear-gradient(to right, rgba(0, 123, 255, 0.07) 1px, transparent 1px);
                    background-size: 2rem 2rem;
                }
                .dark .bg-grid-pattern {
                    background-image: linear-gradient(rgba(255, 193, 7, 0.1) 1px, transparent 1px), linear-gradient(to right, rgba(255, 193, 7, 0.1) 1px, transparent 1px);
                }
                @keyframes pulse-glow {
                    0%, 100% {
                        stroke-opacity: 0.6;
                        filter: drop-shadow(0 0 3px currentColor);
                    }
                    50% {
                        stroke-opacity: 1;
                        filter: drop-shadow(0 0 6px currentColor);
                    }
                }
                .animate-pulse-glow {
                    animation: pulse-glow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                }
                .starting-hidden {
                    opacity: 0;
                    transform: translateY(1rem);
                }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const elements = document.querySelectorAll('.animate-on-load');
                elements.forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.remove('starting-hidden');
                    }, 100 * (index + 1));
                });
            });
        </script>
    </head>
    <body class="bg-gray-50 dark:bg-black text-gray-800 dark:text-gray-200 antialiased overflow-hidden">
        
        <div class="relative flex flex-col items-center justify-center h-screen w-full p-4 lg:p-8 bg-gradient-to-br from-white via-gray-50 to-blue-100 dark:from-black dark:via-gray-900 dark:to-[#0d1a26]">

            <header class="w-full max-w-5xl mx-auto absolute top-0 left-0 right-0 p-6 z-10">
                @if (Route::has('login'))
                    @endif
            </header>

            <main class="w-full max-w-5xl mx-auto flex flex-col lg:flex-row bg-white dark:bg-gray-900/50 backdrop-blur-sm shadow-2xl rounded-2xl overflow-hidden animate-on-load transition-all duration-700 ease-out">
                
                <div class="flex-1 p-8 sm:p-12 lg:p-16">
                    <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white animate-on-load transition-all duration-500 ease-out starting-hidden">
                        Prediksi Beban Listrik Masa Depan
                    </h1>
                    <p class="mt-4 text-base lg:text-lg text-gray-600 dark:text-gray-400 leading-relaxed animate-on-load transition-all duration-500 ease-out starting-hidden" style="transition-delay: 100ms;">
                        Gunakan kekuatan data dan kecerdasan buatan untuk mendapatkan wawasan akurat mengenai kebutuhan listrik di seluruh Indonesia.
                    </p>

                    <ul class="mt-8 space-y-4 animate-on-load transition-all duration-500 ease-out starting-hidden" style="transition-delay: 200ms;">
                        <li class="flex items-start gap-4 group">
                            <span class="flex-shrink-0 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/50 w-8 h-8 mt-1">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.1.4-.27.662-.477.262-.207.583-.466.923-.748.34-.282.72-.634 1.135-1.036.415-.401.855-.855 1.285-1.372l.01-.012c.428-.517.83-1.047 1.176-1.597.346-.55.65-1.128.895-1.725.245-.596.425-1.226.535-1.876.11-.65.16-1.32.16-2.003v-.001C19 5.928 15.365 2.25 10.75 2.25S2.5 5.928 2.5 10.5c0 .683.05 1.353.16 2.003.11.65.29 1.28.535 1.876.245.597.549 1.175.895 1.725.346.55.748 1.08 1.176 1.597l.01.012c.43.517.87.97 1.285 1.372.415.402.795.754 1.135 1.036.34.282.66.54.923.748.262.207.476.377.662.477a5.741 5.741 0 00.281.14l.018.008.006.003zM10 11.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z" clip-rule="evenodd" /></svg>
                            </span>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Peta Prediksi Interaktif</h3>
                                <p class="text-gray-600 dark:text-gray-400">Visualisasikan data prediksi beban listrik secara geografis di seluruh provinsi.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4 group">
                            <span class="flex-shrink-0 flex items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/50 w-8 h-8 mt-1">
                                 <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /><path fill-rule="evenodd" d="M9.879 2.47a.75.75 0 01.742 0l7.5 3.75a.75.75 0 010 1.318l-7.5 3.75a.75.75 0 01-.742 0l-7.5-3.75a.75.75 0 010-1.318l7.5-3.75zM10 6.132L15.368 9 10 11.868 4.632 9 10 6.132zM3.25 11.34a.75.75 0 01.742 0l7.5 3.75a.75.75 0 010 1.318l-7.5 3.75a.75.75 0 01-.742 0l-1.5-3.75a.75.75 0 010-1.318l1.5-3.75z" clip-rule="evenodd" /></svg>
                            </span>
                             <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Model Machine Learning</h3>
                                <p class="text-gray-600 dark:text-gray-400">Dibangun dengan model canggih untuk akurasi dan keandalan yang tinggi.</p>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-10 animate-on-load transition-all duration-500 ease-out starting-hidden" style="transition-delay: 300ms;">
                         <a href="{{ route('login') }}" class="inline-block px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transform transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                            SIGN IN
                        </a>
                    </div>
                </div>

                <div class="relative flex-1 lg:aspect-auto aspect-[1/1] overflow-hidden bg-grid-pattern">
                    <div class="absolute inset-0 bg-gradient-to-t from-white via-white/80 to-transparent dark:from-gray-900/50 dark:via-gray-900/30 dark:to-transparent"></div>
                    
                    <div class="absolute inset-0 flex items-center justify-center p-4">
                        <svg class="w-full h-full text-blue-500 dark:text-yellow-500" viewBox="0 0 440 376" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(20, 50) scale(0.9)">
                                <path class="animate-pulse-glow" d="M10.5,152.5 C10.5,152.5 108.5,149.5 119.5,152.5 C130.5,155.5 161.5,150.5 161.5,150.5 L179.5,168.5 L187.5,161.5 L190.5,146.5 L201.5,138.5 L211.5,142.5 L215.5,154.5 L227.5,154.5 L242.5,161.5 L252.5,154.5 L257.5,146.5 L267.5,139.5 L283.5,141.5 L291.5,154.5 L296.5,154.5 L303.5,147.5 L311.5,148.5 L311.5,161.5 L301.5,173.5 L288.5,178.5 L281.5,188.5 L289.5,192.5 L307.5,190.5 L319.5,202.5 L328.5,203.5 L339.5,214.5 L354.5,214.5 L361.5,209.5 L372.5,211.5 L383.5,225.5 L389.5,221.5 L395.5,211.5 L403.5,202.5 L411.5,203.5 L420.5,212.5 L416.5,223.5 L407.5,232.5 L398.5,232.5 L390.5,241.5 L393.5,251.5 L401.5,257.5 L412.5,254.5 L422.5,261.5 L424.5,272.5 L415.5,278.5 L403.5,274.5 L391.5,283.5 L380.5,283.5 L373.5,275.5 L361.5,274.5 L348.5,284.5 L337.5,281.5 L325.5,269.5 L317.5,271.5 L312.5,281.5 L300.5,281.5 L290.5,271.5 L278.5,274.5 L270.5,268.5 L258.5,271.5 L250.5,263.5 L240.5,264.5 L231.5,258.5 L222.5,263.5 L212.5,260.5 L203.5,251.5 L193.5,252.5 L182.5,243.5 L170.5,247.5 L160.5,240.5 L151.5,243.5 L141.5,235.5 L131.5,238.5 L121.5,231.5 L111.5,235.5 L101.5,228.5 L91.5,231.5 L81.5,224.5 L71.5,228.5 L61.5,221.5 L51.5,225.5 L41.5,218.5 L31.5,222.5 L21.5,215.5 L10.5,152.5 Z" 
                                fill="currentColor" fill-opacity="0.1" stroke="currentColor" stroke-width="1.5" />
                            </g>
                        </svg>
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center">
                         <div class="p-8 bg-white/50 dark:bg-black/50 backdrop-blur-md rounded-2xl shadow-lg animate-on-load transition-all duration-500 ease-out starting-hidden" style="transition-delay: 400ms;">
                             <svg class="w-48 h-auto text-blue-600 dark:text-yellow-400" viewBox="0 0 270 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path d="M55 15 L35 50 L60 50 L40 85 L80 40 L55 40 L75 15 Z" fill="currentColor"/>
                                    <text x="95" y="62" font-family="Instrument Sans, sans-serif" font-size="48" font-weight="bold" fill="currentColor">
                                        PLN
                                    </text>
                                    <text x="97" y="88" font-family="Instrument Sans, sans-serif" font-size="20" font-weight="500" fill="currentColor" opacity="0.9">
                                        PREDICTION
                                    </text>
                                </g>
                            </svg>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </body>
</html>