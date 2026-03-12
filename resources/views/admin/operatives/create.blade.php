<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VOID_COMMANDER | เพิ่มลูกข่ายใหม่</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#050505] text-gray-300 relative font-['JetBrains_Mono']">
    <x-sidebar />
    <x-navbar />

    <div class="scanline"></div>

    <div
        class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 pointer-events-none">
    </div>

    <main class="ml-64 pt-24 min-h-screen p-8 relative z-20">

        <div class="mb-10 text-left w-full border-l-4 border-red-600 pl-6">
            <h1
                class="text-5xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-900 uppercase">
                Operative Command
            </h1>
            <p class="text-xs tracking-[0.4em] text-red-500 uppercase font-bold mt-1">
                ศูนย์บัญชาการและควบคุมลูกข่ายภาคพื้นดิน</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8 w-full max-w-[1600px] mx-auto">

            <div class="xl:col-span-3 space-y-4">
                <div
                    class="bg-black/80 border border-red-900/50 rounded-sm overflow-hidden shadow-[0_0_30px_rgba(0,0,0,0.5)]">
                    <div class="bg-red-900/10 border-b border-red-900/50 p-4 flex justify-between items-center">
                        <h2 class="text-red-500 font-black tracking-[0.2em] uppercase text-xs italic flex items-center">
                            <span class="animate-pulse mr-2">●</span> LIVE_OPERATIVE_FEED
                        </h2>
                        <div class="flex space-x-4 text-[10px] text-gray-500">
                            <span>TOTAL: {{ count($operatives) }}</span>
                            <span class="text-green-900">ENCRYPTION: ACTIVE</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-red-900/30 bg-red-950/5">
                                    <th class="p-4 text-[10px] font-bold text-red-600 uppercase">UID</th>
                                    <th class="p-4 text-[10px] font-bold text-red-600 uppercase">Callsign</th>
                                    <th class="p-4 text-[10px] font-bold text-red-600 uppercase">Clearance</th>
                                    <th class="p-4 text-[10px] font-bold text-red-600 uppercase text-center">
                                        Tactical_Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-[11px] font-mono">
                                @forelse($operatives as $op)
                                    <tr
                                        class="border-b border-red-900/10 hover:bg-red-900/5 transition-all group {{ $op->is_blocked ? 'opacity-40 grayscale' : '' }}">
                                        <td class="p-4 text-gray-600">#{{ str_pad($op->id, 4, '0', STR_PAD_LEFT) }}</td>

                                        <td class="p-4">
                                            <div
                                                class="font-bold text-gray-300 group-hover:text-red-400 transition-colors uppercase">
                                                {{ $op->name }}
                                            </div>
                                            <div class="text-[9px] text-red-900/60 lowercase">@ {{ $op->username }}
                                            </div>
                                        </td>

                                        <td class="p-4">
                                            <span
                                                class="px-2 py-0.5 rounded-sm border 
                            {{ $op->is_blocked ? 'border-gray-600 text-gray-500 bg-gray-900' : ($op->level == 99 ? 'border-red-600 text-red-500 bg-red-600/10 animate-pulse' : 'border-red-900/50 text-red-800') }}">
                                                {{ $op->is_blocked ? 'STATUS_LOCKED' : ($op->level == 99 ? 'MARSHAL_COMMANDER' : 'LVL_0' . $op->level) }}
                                            </span>
                                        </td>

                                        <td class="p-4 text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <button type="button" onclick="editOperative({{ $op->id }})"
                                                    class="inline-flex items-center px-2 py-1 border border-gray-800 text-[9px] font-bold text-gray-500 hover:border-blue-500 hover:text-blue-500 transition-all uppercase bg-black/40 h-7">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 mr-1.5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    EDIT
                                                </button>

                                                @if ($op->level < 99)
                                                    <form action="{{ route('operatives.block', $op->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('ยืนยันการเปลี่ยนแปลงสถานะการเข้าถึง?')">
                                                        @csrf @method('PATCH')
                                                        <button type="submit"
                                                            class="p-1.5 border {{ $op->is_blocked ? 'border-green-600 text-green-600 hover:bg-green-600/10' : 'border-gray-800 text-gray-500 hover:border-red-600 hover:text-red-600' }} transition-all bg-black/50"
                                                            title="{{ $op->is_blocked ? 'ปลดระงับ' : 'ระงับการเข้าถึง' }}">
                                                            @if ($op->is_blocked)
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3.5 w-3.5" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                </svg>
                                                            @endif
                                                        </button>
                                                    </form>
                                                @else
                                                    <div
                                                        class="px-2 py-1 text-[8px] font-black text-red-600 border border-red-600/30 bg-red-600/5 italic tracking-tighter">
                                                        UNSTOPPABLE_CORE
                                                    </div>
                                                @endif
                                                @if ($op->level < 99)
                                                    <form action="{{ route('operatives.destroy', $op->id) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('⚠️ ยืนยันการลบลูกข่ายออกจากฐานข้อมูล? การกระทำนี้ไม่สามารถย้อนคืนได้!')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-1.5 border border-gray-800 text-gray-600 hover:border-red-600 hover:text-red-500 transition-all bg-black/50 group/del"
                                                            title="ลบข้อมูลถาวร">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-3.5 w-3.5 group-hover/del:animate-pulse"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="p-12 text-center text-gray-700 italic tracking-widest uppercase border border-red-900/10">
                                            -- No Active Operatives Found in This Sector --
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4 px-4 py-2 bg-red-950/5 border-t border-red-900/20 tactical-pagination">
                            {{ $operatives->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1">
                <div id="form-container"
                    class="bg-black border {{ $operative ? 'border-blue-500 shadow-[0_0_40px_rgba(59,130,246,0.2)]' : 'border-red-600 shadow-[0_0_40px_rgba(220,38,38,0.1)]' }} p-6 rounded-sm sticky top-24 transition-all">

                    <h3 id="form-title-container"
                        class="{{ $operative ? 'text-blue-500' : 'text-red-500' }} font-black text-xs tracking-widest uppercase mb-6 flex justify-between items-center">
                        <span id="form-title">{{ $operative ? '✎ Edit_Operative' : '✚ Establish_Access' }}</span>

                        <a id="cancel-edit" href="{{ route('operatives.create') }}"
                            class="{{ $operative ? '' : 'hidden' }} text-[9px] text-gray-500 hover:text-white border border-gray-800 px-2 py-1 uppercase transition-colors">
                            Cancel_Edit
                        </a>
                    </h3>

                    <form id="operative-form"
                        action="{{ $operative ? route('operatives.update', $operative->id) : route('operatives.store') }}"
                        method="POST" class="space-y-5">
                        @csrf
                        @if ($operative)
                            @method('PUT')
                        @endif

                        <div class="space-y-4">
                            <div class="group">
                                <label
                                    class="block text-[9px] text-gray-600 font-bold uppercase mb-1 text-[8px] tracking-widest">Callsign</label>
                                <input type="text" name="name" id="input-name"
                                    value="{{ old('name', $operative->name ?? '') }}" required
                                    class="w-full bg-red-950/5 border border-red-900/30 p-2.5 text-xs text-red-500 focus:border-red-500 outline-none transition-all font-bold">
                            </div>

                            <div class="group">
                                <label
                                    class="block text-[9px] text-gray-600 font-bold uppercase mb-1 text-[8px] tracking-widest">Access
                                    Token (Username)</label>
                                <input type="text" name="username" id="input-username"
                                    value="{{ old('username', $operative->username ?? '') }}"
                                    {{ $operative ? 'readonly' : 'required' }}
                                    class="w-full bg-red-950/5 border border-red-900/30 p-2.5 text-xs {{ $operative ? 'text-gray-600' : 'text-red-500' }} focus:border-red-500 outline-none transition-all">

                                @if ($operative)
                                    <p id="username-notice" class="text-[8px] text-gray-700 mt-1 italic">* Username
                                        cannot be changed</p>
                                @endif
                            </div>

                            <div id="password-field" class="group {{ $operative ? 'hidden' : '' }}">
                                <label
                                    class="block text-[9px] text-gray-600 font-bold uppercase mb-1 text-[8px] tracking-widest">Encryption
                                    Key (Password)</label>
                                <input type="password" name="password" {{ $operative ? '' : 'required' }}
                                    class="w-full bg-red-950/5 border border-red-900/30 p-2.5 text-xs text-red-500 focus:border-red-500 outline-none transition-all">
                            </div>

                            <div class="group">
                                <label
                                    class="block text-[9px] text-gray-600 font-bold uppercase mb-1 text-[8px] tracking-widest">
                                    Clearance_Level
                                </label>
                                <select name="level" id="input-level"
                                    class="w-full bg-red-950/5 border border-red-900/30 p-2.5 text-xs text-red-500 focus:border-red-500 outline-none cursor-pointer font-bold">

                                    @for ($i = 1; $i <= 3; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('level', $operative->level ?? '') == $i ? 'selected' : '' }}
                                            class="bg-black text-red-500">
                                            LVL_0{{ $i }} (OPERATIVE)
                                        </option>
                                    @endfor

                                    <option value="99"
                                        {{ old('level', $operative->level ?? '') == 99 ? 'selected' : '' }}
                                        class="bg-red-900 text-white font-black">
                                        LVL_99 (MARSHAL_COMMANDER)
                                    </option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" id="submit-button"
                            class="w-full py-3 {{ $operative ? 'bg-blue-600 hover:bg-blue-500' : 'bg-red-600 hover:bg-red-500' }} text-black font-black text-[10px] tracking-[0.3em] transition-all uppercase shadow-lg">
                            {{ $operative ? 'Update_Record' : 'Deploy_Operative' }}
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <x-footer />
    </main>

    <script src="{{ asset('js/command-center.js') }}"></script>
    <script src="{{ asset('js/operative-commander.js') }}"></script>
</body>

</html>
