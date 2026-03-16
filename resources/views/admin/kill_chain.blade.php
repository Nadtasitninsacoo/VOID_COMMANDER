<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOID_COMMANDER | KILL_CHAIN_STRIKE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#050505] text-gray-300 relative font-['JetBrains_Mono'] overflow-x-hidden">
    <x-sidebar />
    <x-navbar />

    <div class="fixed inset-0 pointer-events-none z-50 opacity-10"
        style="background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06)); background-size: 100% 2px, 3px 100%;">
    </div>

    <main
        class="ml-64 pt-24 min-h-screen p-8 relative z-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">

        <div class="mb-10 flex justify-between items-start border-b border-red-600/30 pb-6">
            <div class="border-l-4 border-red-600 pl-6">
                <h1
                    class="text-4xl font-black tracking-tighter text-red-600 uppercase italic drop-shadow-[0_0_15px_rgba(220,38,38,0.7)]">
                    💀 Kill_Chain_Strike_v2.0
                </h1>
                <p class="text-[10px] tracking-[0.5em] text-red-900 uppercase font-bold mt-2">
                    Operation_Status: <span class="text-yellow-500 animate-pulse">Ready_to_Engage</span> |
                    Tactical_Mode: OFFENSIVE
                </p>
            </div>
            <div class="text-right">
                <div class="text-[10px] text-red-900 uppercase tracking-widest font-bold">Commander_Authorized</div>
                <div class="text-xl text-red-600 font-black">THAN_JOM_PHON</div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <div class="col-span-12 lg:col-span-4 space-y-4">
                <h2 class="text-red-500 font-bold mb-4 flex items-center gap-2 text-xs">
                    <span class="w-3 h-3 bg-red-600 animate-ping"></span> LOG4SHELL_WEAPON_SYSTEMS
                </h2>

                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach ($weapons as $id => $weapon)
                        <button
                            onclick="setPayload('{{ $weapon['payload'] }}', '{{ $id }}', '{{ $weapon['name'] }}')"
                            class="w-full text-left bg-black border border-red-900/30 p-4 hover:bg-red-900/20 hover:border-red-600 transition-all group relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 bg-red-900/20 px-2 py-1 text-[8px] font-bold text-red-600 italic">
                                {{ $id }}
                            </div>
                            <span
                                class="text-[10px] {{ $weapon['severity'] == 'critical' ? 'text-red-500' : 'text-orange-500' }} font-bold block mb-1 group-hover:text-red-400">
                                {{ $weapon['name'] }}
                            </span>
                            <code class="text-[9px] text-gray-600 truncate block">{{ $weapon['payload'] }}</code>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="col-span-12 lg:col-span-8 space-y-6">
                <div class="bg-black/80 border-2 border-red-600/50 p-8 shadow-[0_0_50px_rgba(220,38,38,0.15)] relative">
                    <div
                        class="absolute -top-3 left-6 bg-[#050505] px-4 text-red-600 font-bold text-xs tracking-widest">
                        STRIKE_COORDINATES</div>

                    <form id="strikeForm" action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="text-[10px] text-red-900 uppercase font-bold block mb-2">Target_URL
                                    (Gambling_Site_Endpoint)</label>
                                <input type="text" name="target" placeholder="https://target-gambling.com/api/login"
                                    class="w-full bg-red-950/10 border border-red-600/30 text-red-500 p-4 focus:border-red-600 outline-none font-bold placeholder-red-900/50 transition-all">
                            </div>

                            <div>
                                <label
                                    class="text-[10px] text-red-900 uppercase font-bold block mb-2">Injection_Point</label>
                                <select
                                    class="w-full bg-black border border-red-900/50 text-red-500 text-xs p-4 outline-none">
                                    <option>User-Agent (Highest Success)</option>
                                    <option>X-Forwarded-For</option>
                                    <option>Referer</option>
                                    <option>Custom Header</option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="text-[10px] text-red-900 uppercase font-bold block mb-2">Thread_Count</label>
                                <input type="number" value="1"
                                    class="w-full bg-black border border-red-900/50 text-red-500 p-3 outline-none">
                            </div>
                        </div>

                        <div>
                            <label
                                class="text-[10px] text-red-900 uppercase font-bold block mb-2">Armed_Payload_String</label>
                            <textarea id="payload_area" name="payload" rows="4"
                                class="w-full bg-black/50 border border-red-900/50 text-green-500 text-sm p-4 focus:border-red-600 outline-none font-mono"
                                spellcheck="false" readonly></textarea>
                        </div>

                        <input type="hidden" id="selected_weapon_id" name="weapon_id">

                        <button type="submit"
                            class="w-full bg-red-700 hover:bg-red-600 text-white font-black py-5 transition-all uppercase tracking-[0.5em] text-sm shadow-[0_0_30px_rgba(185,28,28,0.4)] group flex items-center justify-center gap-4">
                            <span>LAUNCH_FATAL_STRIKE</span>
                            <span class="group-hover:translate-x-3 transition-transform">💀💀💀</span>
                        </button>
                    </form>
                </div>

                <div class="bg-black border border-red-900/30 p-4 h-48 overflow-y-auto font-mono text-[10px]">
                    <div class="text-red-900 mb-2 border-b border-red-900/20 pb-1 uppercase font-bold">
                        Action_Logs_Live_Feed</div>
                    <div class="space-y-1" id="terminal_logs">
                        <p class="text-gray-600">>> Waiting for command...</p>
                    </div>
                </div>
            </div>
        </div>
        <x-footer />
    </main>

    <script>
        // สร้าง Global Object เพื่อส่งค่า Route จาก Laravel ไปยังไฟล์ JS ภายนอก
        window.StrikeConfig = {
            executeRoute: '{{ route('admin.execute-strike') }}',
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    <script src="{{ asset('js/kill_chain.js') }}"></script>
</body>

</html>
