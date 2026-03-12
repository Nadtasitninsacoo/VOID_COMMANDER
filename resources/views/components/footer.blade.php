<footer class="mt-auto border-t border-red-900/30 bg-black/40 backdrop-blur-sm w-full py-6 px-8">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">

        <div class="flex items-center space-x-6 text-[10px] tracking-widest text-red-900 font-bold uppercase">
            <div class="flex flex-col">
                <span class="text-gray-600">LATENCY</span>
                <span class="text-red-600">12ms // STABLE</span>
            </div>
            <div class="h-8 w-px bg-red-900/20"></div>
            <div class="flex flex-col">
                <span class="text-gray-600">ENCRYPTION</span>
                <span class="text-red-600">AES-256-GCM</span>
            </div>
        </div>

        <div class="text-center">
            <p class="text-[11px] font-black tracking-[0.3em] uppercase text-red-700">
                VOID COMMANDER <span class="text-gray-500">//</span> v4.0.2-BETA
            </p>
            <p class="text-[9px] text-gray-600 mt-1 uppercase tracking-tighter">
                &copy; 2026 VOID_CORP. ALL RIGHTS RESERVED BY "ท่านจอมพล"
            </p>
        </div>

        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="text-[9px] text-gray-500 uppercase">Current Session ID</p>
                <p class="text-[10px] font-mono text-red-500">VC-{{ strtoupper(Str::random(8)) }}</p>
            </div>
            <div class="w-10 h-10 border border-red-900/50 flex items-center justify-center bg-red-950/20 rounded-sm">
                <span class="text-red-600 animate-pulse">🔒</span>
            </div>
        </div>
    </div>
</footer>
