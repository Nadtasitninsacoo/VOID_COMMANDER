<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VOID_COMMANDER</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-[#050505] text-gray-300 font-['JetBrains_Mono'] overflow-x-hidden">

    <x-sidebar />
    <x-navbar />

    <div class="scanline"></div>

    <div
        class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 pointer-events-none">
    </div>

    <!-- MAIN -->
    <main class="ml-64 pt-24 pb-20 min-h-screen relative z-20">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-10 text-center">
                <h1
                    class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-b from-red-600 to-red-900 uppercase tracking-tighter">
                    VOID COMMANDER
                </h1>
                <div class="mt-2 flex items-center justify-center gap-2 text-red-500">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-ping"></span>
                    <p class="text-[10px] tracking-[0.4em] uppercase opacity-70">ฐานบัญชาการสูงสุด : ท่านจอมพล</p>
                </div>
            </div>

            <div
                class="bg-black/80 border border-red-900/40 p-6 mb-6 shadow-[0_0_40px_rgba(153,0,0,0.1)] relative overflow-hidden">
                <div
                    class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-red-500 to-transparent opacity-30">
                </div>

                <h2 class="text-red-500 font-bold mb-6 flex items-center gap-2 text-[10px] tracking-widest uppercase">
                    <span class="animate-pulse text-red-600">●</span> Operative_Deployment_Analytics
                </h2>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="h-[200px] relative">
                        <canvas id="levelChart" data-low="{{ $lvlLow }}" data-high="{{ $lvlHigh }}"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-[8px] text-red-900 uppercase tracking-tighter">Power_Scale</span>
                            <span class="text-xl font-black text-red-600">INTEL</span>
                        </div>
                    </div>

                    <div class="h-[200px]">
                        <canvas id="statusChart" data-act="{{ $statusAct }}" data-sby="{{ $statusSby }}"
                            data-blk="{{ $statusBlk }}"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-10">

                <div class="bg-black/60 border-l border-red-600 p-3 shadow-lg">
                    <p class="text-[8px] text-red-900 font-bold uppercase mb-1">Integrity</p>
                    <div class="flex items-baseline justify-between">
                        <span class="text-lg font-black text-gray-200">{{ number_format($integrity, 1) }}<span
                                class="text-[10px] text-red-600">%</span></span>
                        <span
                            class="text-[7px] {{ $integrity > 90 ? 'text-green-600' : 'text-yellow-600' }} animate-pulse uppercase">
                            {{ $integrity > 90 ? 'STABLE' : 'WARNING' }}
                        </span>
                    </div>
                </div>

                <div class="bg-black/60 border-l border-red-600 p-3 shadow-lg">
                    <p class="text-[8px] text-red-900 font-bold uppercase mb-1">Active_Nodes</p>
                    <div class="flex items-baseline justify-between">
                        <span class="text-lg font-black text-gray-200">{{ $activeNodes }}<span
                                class="text-[10px] text-red-600">/{{ $totalNodes }}</span></span>
                        <div class="flex gap-0.5">
                            @for ($i = 0; $i < 3; $i++)
                                <div
                                    class="w-1 h-1.5 {{ $i < ($activeNodes / ($totalNodes ?: 1)) * 3 ? 'bg-red-600' : 'bg-red-900/30' }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="bg-black/60 border-l border-red-600 p-3 shadow-lg">
                    <p class="text-[8px] text-red-900 font-bold uppercase mb-1">Threat_Level</p>
                    <div class="flex items-baseline justify-between">
                        <span
                            class="text-lg font-black {{ $threatLevel == 'HIGH' ? 'text-red-500' : 'text-gray-400' }} uppercase">{{ $threatLevel }}</span>
                        <span
                            class="text-[7px] text-red-900 uppercase">DEFCON_{{ $threatLevel == 'HIGH' ? '2' : '5' }}</span>
                    </div>
                </div>

                <div class="bg-black/60 border-l border-red-600 p-3 shadow-lg">
                    <p class="text-[8px] text-red-900 font-bold uppercase mb-1">Uplink_Status</p>
                    <div class="flex items-baseline justify-between">
                        <span class="text-lg font-black text-gray-200">ONLINE</span>
                        <span class="text-[7px] text-red-600 uppercase">▲ SECURE</span>
                    </div>
                </div>
            </div>

            <div class="relative py-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-red-900/10"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-[#050505] px-4 text-[8px] text-red-950 tracking-[1em] uppercase">End of
                        Transmission</span>
                </div>
            </div>

        </div>
        <x-footer />
    </main>

    <script src="{{ asset('js/welcome.js') }}"></script>

</body>

</html>
