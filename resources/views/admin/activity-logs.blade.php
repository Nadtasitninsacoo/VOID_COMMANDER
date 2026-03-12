<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VOID_COMMANDER | Audit Trail Logs</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/activity-logs.css') }}">
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
                    Audit Trail
                </h1>
                <p class="text-xs tracking-[0.4em] text-red-500 uppercase font-bold mt-1">
                    บันทึกร่องรอยกิจกรรมและการเข้าถึงระบบเชิงลึก
                </p>
            </div>
            <div class="hidden xl:block text-right">
                <div class="text-[10px] text-red-900/60 font-bold uppercase tracking-widest mb-1">System_Uptime</div>
                <div id="uptime_clock"
                    class="text-xl font-bold text-red-600 tabular-nums drop-shadow-[0_0_5px_#dc2626]">
                    00:00:00
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 w-full max-w-[1600px] mx-auto font-mono">

            <div
                class="bg-black/80 border border-red-900/50 rounded-sm overflow-hidden shadow-[0_0_50px_rgba(153,0,0,0.1)]">

                <div
                    class="bg-red-900/10 border-b border-red-900/50 p-4 flex justify-between items-center relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-full bg-gradient-to-l from-red-600/5 to-transparent pointer-events-none">
                    </div>

                    <h2
                        class="text-red-500 font-black tracking-[0.2em] uppercase text-xs italic flex items-center z-10">
                        <span class="animate-pulse mr-2 text-red-600">●</span> TRACE_ACTIVITY_FEED
                    </h2>

                    <div class="flex items-center gap-6 z-10">
                        <div class="hidden md:flex space-x-6 text-[10px] font-bold border-r border-red-900/30 pr-6">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600">RECORDS:</span>
                                <span class="text-red-500 tabular-nums">{{ $logs->total() }}</span>
                            </div>
                        </div>

                        @if ($logs->total() > 0)
                            <form action="{{ route('logs.purge') }}" method="POST"
                                onsubmit="return confirm('CRITICAL_WARNING: ระบบกำลังจะกวาดล้างข้อมูล Log ทั้งหมด! ยืนยันคำสั่งทำลายล้าง?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="group relative flex items-center gap-3 px-4 py-1.5 bg-black border border-red-900 hover:border-red-600 transition-all active:scale-95 shadow-[0_0_15px_rgba(153,0,0,0.1)]">

                                    <div
                                        class="absolute inset-0 w-full h-[1px] bg-red-600/50 top-0 group-hover:animate-[scan_1.5s_linear_infinite] pointer-events-none">
                                    </div>

                                    <span
                                        class="text-sm group-hover:rotate-180 transition-transform duration-500">☢️</span>

                                    <div class="flex flex-col items-start leading-none">
                                        <span
                                            class="text-[10px] font-black text-red-600 tracking-tighter group-hover:text-red-500">PURGE_LOGS</span>
                                        <span
                                            class="text-[7px] text-red-900 font-bold uppercase tracking-[0.2em]">Data_Erasing</span>
                                    </div>

                                    <div
                                        class="ml-1 w-1 h-3 bg-red-950 group-hover:bg-red-600 shadow-[0_0_5px_rgba(220,38,38,0.5)] transition-colors">
                                    </div>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="overflow-x-auto relative">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-red-900/30 bg-red-950/5">
                                <th class="p-4 text-[10px] font-bold text-red-600 uppercase tracking-widest w-40">
                                    Timestamp</th>
                                <th class="p-4 text-[10px] font-bold text-red-600 uppercase tracking-widest">Operator /
                                    Task</th>
                                <th
                                    class="p-4 text-[10px] font-bold text-red-600 uppercase tracking-widest text-center w-32">
                                    Severity</th>
                                <th class="p-4 text-[10px] font-bold text-red-600 uppercase tracking-widest text-right">
                                    Trace_Source</th>
                            </tr>
                        </thead>
                        <tbody class="text-[11px]">
                            @forelse($logs as $log)
                                <tr class="border-b border-red-900/10 hover:bg-red-900/5 transition-all group">
                                    <td class="p-4 text-gray-600 italic">
                                        {{ $log->created_at->format('Y/m/d') }}<br>
                                        <span
                                            class="text-gray-400 font-bold">{{ $log->created_at->format('H:i:s') }}</span>
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="px-2 py-0.5 bg-red-950/30 border border-red-900/50 text-red-500 font-black tracking-tighter">
                                                {{ $log->user->name ?? 'CENTRAL_AI' }}
                                            </span>
                                            <span
                                                class="text-gray-300 font-bold uppercase tracking-tight group-hover:text-red-400 transition-colors italic">
                                                > {{ $log->subject }}
                                            </span>
                                        </div>
                                        @if ($log->details)
                                            <div
                                                class="mt-2 text-[10px] text-gray-500 pl-4 border-l border-red-900/30 max-w-2xl leading-relaxed">
                                                {{ $log->details }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @switch($log->severity)
                                            @case('critical')
                                                <span
                                                    class="px-3 py-1 bg-red-600 text-black font-black text-[9px] animate-pulse shadow-[0_0_15px_rgba(220,38,38,0.5)]">
                                                    CRITICAL_THREAT
                                                </span>
                                            @break

                                            @case('warning')
                                                <span
                                                    class="px-3 py-1 border border-orange-600 text-orange-500 font-bold text-[9px]">
                                                    WARNING
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="px-3 py-1 border border-blue-900/50 text-blue-800 font-bold text-[9px] opacity-60">
                                                    INFORMATION
                                                </span>
                                        @endswitch
                                    </td>

                                    <td class="p-4 text-right">
                                        <div class="text-red-900/60 font-bold">{{ $log->ip_address }}</div>
                                        <div class="text-[8px] text-gray-700 truncate max-w-[200px] ml-auto"
                                            title="{{ $log->user_agent }}">
                                            {{ Str::limit($log->user_agent, 40) }}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-20 text-center">
                                            <div class="inline-block border-2 border-dashed border-red-900/20 px-10 py-6">
                                                <p class="text-gray-700 italic tracking-[0.5em] uppercase font-bold">--
                                                    NO_DATA_DETECTED_IN_SECTOR --</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 bg-red-950/5 border-t border-red-900/30">
                        <div class="tactical-pagination">
                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>

                <div
                    class="flex justify-between items-center text-[9px] text-red-900/40 font-bold uppercase tracking-widest">
                    <div>Encryption_Method: RSA_4096_V.2</div>
                    <div>Void_Commander_Internal_Forensics</div>
                </div>
            </div>

            <x-footer />
        </main>

        <script src="{{ asset('js/activity-logs.js') }}"></script>
    </body>

    </html>
