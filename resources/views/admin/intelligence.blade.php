<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOID_COMMANDER | INTELLIGENCE_FEED</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/intelligence.css') }}">
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

        <div
            class="mb-10 flex justify-between items-start border-b border-blue-600/30 pb-6 shadow-[0_15px_30px_-15px_rgba(37,99,235,0.2)]">
            <div class="border-l-4 border-blue-600 pl-6">
                <h1
                    class="text-4xl font-black tracking-tighter text-blue-600 uppercase italic drop-shadow-[0_0_15px_rgba(37,99,235,0.7)]">
                    📡 Intelligence_Intercept_v1.0
                </h1>
                <p class="text-[10px] tracking-[0.5em] text-blue-900 uppercase font-bold mt-2">
                    Intercept_Status: <span class="text-green-500 animate-pulse">Live_Listening</span> |
                    Signal_Strength: ENHANCED
                </p>
            </div>
            <div class="text-right">
                <div class="text-[10px] text-blue-900 uppercase tracking-widest font-bold">Commander_Authorized</div>
                <div class="text-xl text-blue-600 font-black italic">THAN_JOM_PHON</div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <div class="col-span-12 grid grid-cols-4 gap-4 mb-4">
                <div class="bg-black/60 border border-blue-900/30 p-4 text-center">
                    <div class="text-[10px] text-gray-500 uppercase">Total_Intercepts</div>
                    <div class="text-2xl font-bold text-blue-500">{{ $reports->total() }}</div>
                </div>
                <div class="bg-black/60 border border-blue-900/30 p-4 text-center">
                    <div class="text-[10px] text-gray-500 uppercase">Media_Captured</div>
                    <div class="text-2xl font-bold text-green-500">
                        {{ $reports->where('file_path', '!=', null)->count() }}</div>
                </div>
                <div class="bg-black/60 border border-blue-900/30 p-4 text-center">
                    <div class="text-[10px] text-gray-500 uppercase">Active_Targets</div>
                    <div class="text-2xl font-bold text-yellow-500">{{ $reports->unique('source_ip')->count() }}</div>
                </div>
                <div
                    class="bg-black/60 border border-blue-900/30 p-4 text-center font-mono text-[10px] flex items-center justify-center text-red-500">
                    <span class="animate-ping mr-2 inline-flex h-2 w-2 rounded-full bg-red-600 opacity-75"></span>
                    SYSTEM_LIVE_INTERCEPTING...
                </div>
            </div>

            <div class="col-span-12 space-y-4">
                @forelse ($reports as $report)
                    <div
                        class="bg-black/80 border border-blue-900/20 hover:border-blue-600/50 transition-all p-6 relative group overflow-hidden">
                        <div
                            class="absolute inset-0 bg-blue-600/5 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>

                        <div class="relative z-10 flex flex-col lg:flex-row gap-6">
                            <div class="lg:w-1/4 border-r border-blue-900/20 pr-6">
                                <div class="text-[10px] text-blue-900 font-bold mb-1 uppercase tracking-tighter">
                                    Target_IP_Address</div>
                                <div class="text-xl font-black text-blue-500 mb-2 font-mono">{{ $report->source_ip }}
                                </div>
                                <div class="text-[10px] text-gray-500 font-mono italic">
                                    Intercepted: {{ $report->captured_at->format('Y-m-d H:i:s') }}<br>
                                    ({{ $report->captured_at->diffForHumans() }})
                                </div>
                            </div>

                            <div class="lg:w-2/4">
                                <div class="text-[10px] text-blue-900 font-bold mb-1 uppercase tracking-tighter">
                                    Intercepted_Data_Stream</div>
                                <div
                                    class="bg-black p-3 border border-gray-900 rounded-sm overflow-x-auto max-h-32 custom-scrollbar">
                                    <code class="text-xs text-green-600 break-all leading-relaxed">
                                        {{ $report->leaked_data }}
                                    </code>
                                </div>
                            </div>

                            <div class="lg:w-1/4 flex flex-col justify-center items-end">
                                @if ($report->file_path)
                                    <div class="text-[10px] text-blue-400 font-bold mb-2 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-blue-500 animate-pulse rounded-full"></span>
                                        MEDIA_ATTACHED [{{ strtoupper($report->file_type) }}]
                                    </div>
                                    @if (in_array(strtolower($report->file_type), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ Storage::url($report->file_path) }}"
                                            class="w-24 h-24 object-cover border border-blue-900 p-1 mb-2">
                                    @else
                                        <div
                                            class="w-24 h-24 flex items-center justify-center bg-blue-950/20 border border-blue-900 mb-2">
                                            <span class="text-2xl">📽️</span>
                                        </div>
                                    @endif
                                    <div class="flex gap-2">
                                        <a href="{{ Storage::url($report->file_path) }}" target="_blank"
                                            class="text-[9px] bg-blue-700 hover:bg-blue-600 text-white px-3 py-1 font-bold">VIEW</a>
                                        <a href="{{ Storage::url($report->file_path) }}" download
                                            class="text-[9px] bg-gray-800 hover:bg-gray-700 text-white px-3 py-1 font-bold">DL</a>
                                    </div>
                                @else
                                    <div class="text-[9px] text-gray-700 italic">No Media Payload Attached</div>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('admin.intelligence.destroy', $report->id) }}" method="POST"
                            class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-900 hover:text-red-500 text-xs font-bold"
                                onclick="return confirm('Confirm Data Purge?')">
                                [×] PURGE_INTEL
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-black/50 border border-gray-900 p-20 text-center">
                        <div class="text-4xl mb-4 opacity-20">📡</div>
                        <div class="text-gray-600 font-bold tracking-[0.3em] uppercase">Waiting for incoming signal...
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="col-span-12 mt-6">
                {{ $reports->links() }}
            </div>

        </div>

        <x-footer />
    </main>

</body>

</html>
