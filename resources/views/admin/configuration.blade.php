<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VOID_COMMANDER | System Configuration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#050505] text-gray-300 relative font-['JetBrains_Mono'] overflow-x-hidden">
    <x-sidebar />
    <x-navbar />

    <div class="scanline"></div>

    <div
        class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 pointer-events-none">
    </div>

    <main class="ml-64 pt-24 min-h-screen p-8 relative z-20">

        <div class="mb-10 text-left w-full border-l-4 border-red-600 pl-6 flex justify-between items-end">
            <div>
                <h1
                    class="text-5xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-900 uppercase italic">
                    Configuration
                </h1>
                <p class="text-xs tracking-[0.4em] text-red-500 uppercase font-bold mt-1">
                    แผงควบคุมนโยบายระบบและสถานะยุทธการ
                </p>
            </div>
            <div class="hidden xl:block text-right">
                <div class="text-[10px] text-red-900/60 font-bold uppercase tracking-widest mb-1">System_Clock</div>
                <div class="text-xl font-bold text-red-600 tabular-nums">{{ now()->format('H:i:s') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 w-full max-w-[1200px] mx-auto font-mono">

            @if (session('success'))
                <div
                    class="bg-green-950/20 border border-green-600/50 p-4 text-green-500 text-xs font-bold tracking-widest uppercase animate-pulse">
                    [SUCCESS]: {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.config.update') }}" method="POST">
                @csrf
                <div
                    class="bg-black/80 border border-red-900/50 rounded-sm overflow-hidden shadow-[0_0_50px_rgba(153,0,0,0.1)]">

                    <div class="bg-red-900/10 border-b border-red-900/50 p-4 flex justify-between items-center">
                        <h2 class="text-red-500 font-black tracking-[0.2em] uppercase text-xs italic flex items-center">
                            <span class="animate-pulse mr-2 text-red-600">●</span> CORE_SYSTEM_POLICY
                        </h2>
                        <div class="text-[10px] text-gray-600 font-bold uppercase">
                            Access_Level: <span class="text-red-600">COMMANDER_ONLY</span>
                        </div>
                    </div>

                    <div class="p-8 space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            {{-- 01 // Operation Mode --}}
                            <div class="space-y-4">
                                <label class="block text-[10px] font-bold text-red-600 uppercase tracking-[0.3em]">01 //
                                    Operation_Mode</label>
                                <select name="operation_mode"
                                    class="w-full bg-red-950/5 border border-red-900/30 text-gray-300 py-3 px-4 focus:border-red-600 outline-none transition-all uppercase text-sm">
                                    <option value="SOLO" {{ $settings->operation_mode == 'SOLO' ? 'selected' : '' }}
                                        class="bg-[#050505]">SOLO_OPERATIVE</option>
                                    <option value="TEAM" {{ $settings->operation_mode == 'TEAM' ? 'selected' : '' }}
                                        class="bg-[#050505]">TEAM_DEPLOYMENT</option>
                                </select>
                            </div>

                            {{-- 02 // System Status --}}
                            <div class="space-y-4">
                                <label class="block text-[10px] font-bold text-red-600 uppercase tracking-[0.3em]">02 //
                                    System_Status</label>
                                <select name="system_status"
                                    class="w-full bg-red-950/5 border border-red-900/30 text-gray-300 py-3 px-4 focus:border-red-600 outline-none transition-all uppercase text-sm">
                                    <option value="ONLINE" {{ $settings->system_status == 'ONLINE' ? 'selected' : '' }}
                                        class="bg-[#050505]">🟢 STATUS_ONLINE</option>
                                    <option value="MAINTENANCE"
                                        {{ $settings->system_status == 'MAINTENANCE' ? 'selected' : '' }}
                                        class="bg-[#050505]">🟡 UNDER_MAINTENANCE</option>
                                    <option value="EMERGENCY_LOCK"
                                        {{ $settings->system_status == 'EMERGENCY_LOCK' ? 'selected' : '' }}
                                        class="bg-[#050505]">🔴 EMERGENCY_PROTOCOL_LOCK</option>
                                </select>
                            </div>
                        </div>

                        {{-- Log Config --}}
                        <div class="border-t border-red-900/20 pt-10">
                            <div class="flex items-center justify-between bg-red-950/5 border border-red-900/20 p-6">
                                <div class="space-y-1">
                                    <h3 class="text-sm font-bold text-gray-100 uppercase tracking-widest">
                                        Allow_Operative_Logs</h3>
                                    <p class="text-[9px] text-red-900/60 uppercase font-black">สภาวะการบันทึกกิจกรรมใน
                                        Sector</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="allow_operative_logs" value="1"
                                        {{ $settings->allow_operative_logs ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-14 h-7 bg-gray-900 border border-red-900/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-red-600 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-red-950 after:border-red-900 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600/20 peer-checked:border-red-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 03 // Broadcast Message (จุดที่แก้ไข) --}}
                        <div class="space-y-4 border-t border-red-900/20 pt-10">
                            <div class="flex justify-between items-end mb-2">
                                <label class="block text-[10px] font-bold text-red-600 uppercase tracking-[0.3em]">
                                    03 // Broadcast_Message
                                </label>

                                {{-- ปุ่มจะแสดงเมื่อมีข้อความ และต้องอยู่นอกฟอร์มหลัก หรือใช้ฟอร์มแยก --}}
                                @if (!empty($settings->maintenance_message))
                                    <button type="button"
                                        onclick="if(confirm('CONFIRM_SIGNAL_TERMINATION?')) document.getElementById('clear-broadcast-form').submit();"
                                        class="text-[9px] text-red-500 hover:text-white hover:bg-red-600 border border-red-600/30 px-3 py-1 transition-all font-black uppercase tracking-widest bg-red-900/10">
                                        [!] TERMINATE_SIGNAL
                                    </button>
                                @endif
                            </div>

                            <textarea name="maintenance_message" rows="3"
                                class="w-full bg-red-950/5 border border-red-900/30 text-gray-300 p-4 focus:border-red-600 outline-none transition-all text-xs"
                                placeholder="-- ป้อนข้อความเพื่อประกาศให้ลูกข่ายทราบ --">{{ $settings->maintenance_message }}</textarea>
                        </div>
                    </div>

                    <div class="bg-red-950/10 border-t border-red-900/50 p-6 flex justify-between items-center">
                        <div class="text-[9px] text-gray-600 italic">LAST_UPDATE:
                            {{ $settings->updated_at ?? 'NEVER' }}</div>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-black font-black uppercase text-xs px-10 py-3 tracking-[0.2em] shadow-[0_0_20px_rgba(220,38,38,0.3)] transition-all active:scale-95">
                            Apply_Changes_Now
                        </button>
                    </div>
                </div>
            </form>

            {{-- ฟอร์มซ่อนสำหรับการล้างค่า (เพื่อไม่ให้ตีกับฟอร์มหลัก) --}}
            <form id="clear-broadcast-form" action="{{ route('admin.config.clear-broadcast') }}" method="POST"
                class="hidden">
                @csrf
                @method('PATCH')
            </form>

            <div
                class="flex justify-between items-center text-[9px] text-red-900/40 font-bold uppercase tracking-widest mt-4">
                <div>Encryption_Method: AES_256_GCM</div>
                <div>Void_Commander_Internal_Security_Module</div>
            </div>
        </div>

        <x-footer />
    </main>
</body>

</html>
