<aside class="fixed left-0 top-0 h-screen w-64 bg-black/90 border-r border-red-900/50 z-50 transition-all duration-300">
    <div class="p-6 border-b border-red-900/30 flex items-center space-x-3">
        <div
            class="w-8 h-8 bg-red-600 rounded-sm animate-pulse shadow-[0_0_10px_rgba(220,38,38,0.5)] flex items-center justify-center font-bold text-black">
            VC</div>
        <span class="text-xl font-black tracking-tighter text-red-600 uppercase">Void Cmd</span>
    </div>

    <nav class="mt-8 px-4 space-y-2">
        <div class="text-[10px] text-red-900 font-bold uppercase tracking-[0.2em] mb-4 ml-2">Main Terminal</div>

        <a href="{{ route('dashboard') }}" id="dashboard-btn"
            class="group flex items-center px-4 py-3 text-sm font-medium transition-all border-l-2 {{ request()->routeIs('dashboard') ? 'text-green-500 bg-green-900/10 border-green-600 shadow-[inset_0_0_15px_rgba(22,163,74,0.2)]' : 'text-gray-500 hover:text-green-400 hover:bg-green-900/5 border-transparent hover:border-green-900' }}">

            <span
                class="mr-3 text-xl {{ request()->routeIs('dashboard') ? 'opacity-100 drop-shadow-[0_0_12px_rgba(220,38,38,0.9)] text-red-600 scale-110' : 'opacity-40 group-hover:opacity-100 group-hover:rotate-12 group-hover:scale-110 transition-all duration-300' }}">

                @if (request()->routeIs('dashboard'))
                    📡
                @else
                    ⚡
                @endif
            </span>

            <div class="flex flex-col">
                <span
                    class="text-[10px] font-black tracking-[0.2em] uppercase {{ request()->routeIs('dashboard') ? 'text-green-500' : '' }}">
                    DASHBOARD
                </span>
                <span
                    class="text-[8px] text-gray-700 font-bold uppercase tracking-widest mt-0.5 italic group-hover:text-green-900/60 transition-colors">
                    Core_Command_Center
                </span>
            </div>

            @if (request()->routeIs('dashboard'))
                <div class="ml-auto flex items-center space-x-1">
                    <div class="w-1 h-3 bg-green-600/50 animate-[pulse_1s_infinite]"></div>
                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full shadow-[0_0_8px_rgba(34,197,94,1)]"></div>
                </div>
            @endif
        </a>

        <a href="javascript:void(0);" id="intelligence-btn" data-url="{{ route('admin.intelligence') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium transition-all border-l-2 {{ request()->routeIs('admin.intelligence') ? 'text-blue-500 bg-blue-900/10 border-blue-600 shadow-[inset_0_0_10px_rgba(37,99,235,0.2)]' : 'text-gray-500 hover:text-blue-400 hover:bg-blue-900/5 border-transparent hover:border-blue-900' }}">

            <span
                class="mr-3 text-lg {{ request()->routeIs('admin.intelligence') ? 'opacity-100 animate-pulse drop-shadow-[0_0_8px_rgba(220,38,38,0.8)]' : 'opacity-50 group-hover:opacity-100 group-hover:scale-125 transition-all duration-300' }}">

                @if (request()->routeIs('admin.intelligence'))
                    👁️‍🗨️
                @else
                    🕵️
                @endif
            </span>

            <div class="flex flex-col">
                <span
                    class="text-[10px] font-black tracking-[0.2em] uppercase {{ request()->routeIs('admin.intelligence') ? 'text-blue-500' : '' }}">
                    INTELLIGENCE
                </span>
                <span class="text-[8px] text-gray-700 font-bold uppercase tracking-widest mt-0.5 italic">
                    Signal_Intercept_Unit
                </span>
            </div>

            @if (request()->routeIs('admin.intelligence'))
                <div class="ml-auto w-1.5 h-1.5 bg-blue-600 rounded-full animate-ping"></div>
            @endif
        </a>

        <a href="javascript:void(0);" id="kill-chain-btn" data-url="{{ route('admin.kill_chain') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium transition-all border-l-2 {{ request()->routeIs('admin.kill_chain') ? 'text-red-500 bg-red-900/10 border-red-600 shadow-[inset_0_0_10px_rgba(220,38,38,0.2)]' : 'text-gray-500 hover:text-red-400 hover:bg-red-900/5 border-transparent hover:border-red-900' }}">

            <span
                class="mr-3 text-lg {{ request()->routeIs('admin.kill_chain') ? 'opacity-100 animate-pulse' : 'opacity-50 group-hover:opacity-100' }}">
                💀
            </span>

            <div class="flex flex-col">
                <span
                    class="text-[10px] font-black tracking-[0.2em] uppercase {{ request()->routeIs('admin.kill_chain') ? 'text-red-500' : '' }}">
                    Kill Chain
                </span>
                <span class="text-[8px] text-gray-700 font-bold uppercase tracking-widest mt-0.5 italic">
                    Offensive_Strike_Link
                </span>
            </div>

            @if (request()->routeIs('admin.kill_chain'))
                <div class="ml-auto w-1.5 h-1.5 bg-red-600 rounded-full animate-ping"></div>
            @endif
        </a>

        <a href="javascript:void(0);" id="vuln-scanner-btn" data-url="{{ route('admin.vulnerability_scan') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium transition-all border-l-2 {{ request()->routeIs('admin.vulnerability_scan') ? 'text-red-500 bg-red-900/10 border-red-600 shadow-[inset_0_0_10px_rgba(220,38,38,0.2)]' : 'text-gray-500 hover:text-red-400 hover:bg-red-900/5 border-transparent hover:border-red-900' }}">

            <span
                class="mr-3 text-lg {{ request()->routeIs('admin.vulnerability_scan') ? 'opacity-100 animate-pulse' : 'opacity-50 group-hover:opacity-100' }}">
                ☣️ </span>

            <div class="flex flex-col">
                <span
                    class="text-[10px] font-black tracking-[0.2em] uppercase {{ request()->routeIs('admin.vulnerability_scan') ? 'text-red-500' : '' }}">
                    VULN_SCANNER
                </span>
                <span class="text-[8px] text-gray-700 font-bold uppercase tracking-widest mt-0.5 italic">
                    F-22_Targeting_System
                </span>
            </div>

            @if (request()->routeIs('admin.vulnerability_scan'))
                <div class="ml-auto w-1.5 h-1.5 bg-red-600 rounded-full animate-ping"></div>
            @endif
        </a>

        <div
            class="pt-8 text-[10px] text-red-900 font-bold uppercase tracking-[0.2em] mb-4 ml-2 border-t border-red-900/20 mt-4">
            System Ops</div>

        <a href="javascript:void(0);" id="add-operative-btn" data-url="{{ route('operatives.create') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium transition-all border-l-2 {{ request()->routeIs('operatives.create') ? 'text-red-500 bg-red-900/10 border-red-600 shadow-[inset_0_0_10px_rgba(220,38,38,0.2)]' : 'text-gray-500 hover:text-red-400 hover:bg-red-900/5 border-transparent hover:border-red-900' }}">

            <span
                class="mr-3 text-lg {{ request()->routeIs('operatives.create') ? 'opacity-100 animate-pulse' : 'opacity-50 group-hover:opacity-100' }}">
                👥
            </span>

            <div class="flex flex-col">
                <span
                    class="text-[10px] font-black tracking-[0.2em] uppercase {{ request()->routeIs('operatives.create') ? 'text-red-500' : '' }}">
                    ADD_OPERATIVE
                </span>
                <span class="text-[8px] text-gray-700 font-bold uppercase tracking-widest mt-0.5 italic">
                    Recruit_New_Agent
                </span>
            </div>

            @if (request()->routeIs('operatives.create'))
                <div class="ml-auto w-1.5 h-1.5 bg-red-600 rounded-full animate-ping"></div>
            @endif
        </a>

        <a href="javascript:void(0);" id="config-protocol-btn" data-url="{{ route('admin.config') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium transition-all border-l-2 {{ request()->routeIs('admin.config') ? 'text-red-500 bg-red-900/10 border-red-600 shadow-[inset_0_0_10px_rgba(220,38,38,0.2)]' : 'text-gray-500 hover:text-red-400 hover:bg-red-900/5 border-transparent hover:border-red-900' }}">

            <span
                class="mr-3 text-lg {{ request()->routeIs('admin.config') ? 'opacity-100 animate-pulse' : 'opacity-50 group-hover:opacity-100' }}">
                ⚙️
            </span>

            <div class="flex flex-col">
                <span
                    class="text-[10px] font-black tracking-[0.2em] uppercase {{ request()->routeIs('admin.config') ? 'text-red-500' : '' }}">
                    CONFIGURATION
                </span>
                <span class="text-[8px] text-gray-700 font-bold uppercase tracking-widest mt-0.5 italic">
                    System_Main_Protocol
                </span>
            </div>

            @if (request()->routeIs('admin.config'))
                <div class="ml-auto w-1.5 h-1.5 bg-red-600 rounded-full animate-ping"></div>
            @endif
        </a>

        <a href="{{ route('logs.index') }}"
            class="group flex items-center px-4 py-3 text-sm font-medium transition-all border-l-2 {{ request()->routeIs('logs.index') ? 'text-red-500 bg-red-900/10 border-red-600 shadow-[inset_0_0_10px_rgba(220,38,38,0.2)]' : 'text-gray-500 hover:text-red-400 hover:bg-red-900/5 border-transparent hover:border-red-900' }}">

            <div
                class="mr-3 text-lg {{ request()->routeIs('logs.index') ? 'text-red-600' : 'opacity-50 group-hover:opacity-100 group-hover:scale-110' }} transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>

            <div class="flex flex-col">
                <span
                    class="text-[10px] font-black tracking-[0.2em] uppercase {{ request()->routeIs('logs.index') ? 'text-red-500' : '' }}">
                    AUDIT_TRAIL
                </span>
                <span class="text-[8px] text-gray-700 font-bold uppercase tracking-widest mt-0.5 italic text-nowrap">
                    Forensic_Logs_Archive
                </span>
            </div>

            @if (request()->routeIs('logs.index'))
                <div class="ml-auto w-1.5 h-1.5 bg-red-600 rounded-full animate-ping"></div>
            @endif
        </a>

        <a href="javascript:void(0);"
            onclick="confirmTacticalAction(event, document.getElementById('logout-form'), 'ยืนยันการตัดการเชื่อมต่อจากระบบส่วนกลาง?')"
            class="group relative flex items-center px-6 py-4 mt-auto mx-2 mb-2 text-sm font-black text-red-500 bg-red-950/20 rounded-lg border border-red-900/40 hover:bg-red-600 hover:text-white hover:shadow-[0_0_20px_rgba(220,38,38,0.5)] transition-all duration-300 overflow-hidden">

            <div
                class="absolute inset-0 bg-gradient-to-r from-red-600/0 via-red-600/10 to-red-600/0 group-hover:via-red-600/20 transition-all">
            </div>

            <span
                class="relative mr-4 text-xl filter drop-shadow-[0_0_8px_rgba(220,38,38,0.8)] group-hover:scale-125 group-hover:rotate-12 transition-transform duration-300">
                🔌
            </span>

            <span class="relative tracking-[0.2em] uppercase text-[11px]">
                Terminate Connection
            </span>

            <span
                class="absolute right-4 w-1.5 h-1.5 bg-red-600 rounded-full animate-pulse shadow-[0_0_10px_rgba(220,38,38,1)]"></span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>

    <div class="absolute bottom-0 w-full p-4 border-t border-red-900/30 bg-black/50">
        <div class="flex items-center space-x-3 opacity-60 hover:opacity-100 transition-opacity cursor-pointer">
            <div
                class="w-10 h-10 bg-gray-800 border border-red-900 rounded-full flex items-center justify-center text-xs">
                J.P.</div>
            <div>
                <p class="text-[10px] font-bold text-red-600 leading-tight">STATUS: ONLINE</p>
                <p class="text-[9px] text-gray-500 uppercase tracking-tighter">ท่านจอมพล</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/command-center.js') }}"></script>
</aside>
