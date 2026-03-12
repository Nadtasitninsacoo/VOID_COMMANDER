<nav
    class="fixed top-0 right-0 left-64 h-16 bg-black/80 backdrop-blur-md border-b border-red-900/30 z-40 flex items-center justify-between px-8">
    <div class="flex items-center space-x-6 text-[10px] tracking-widest text-red-900 font-bold uppercase">
        <div class="flex items-center space-x-2">
            <span class="w-1 h-1 bg-green-500 rounded-full shadow-[0_0_5px_rgba(34,197,94,1)]"></span>
            <span>Server: Stable</span>
        </div>
        <div class="hidden md:flex items-center space-x-2">
            <span class="w-1 h-1 bg-red-600 rounded-full"></span>
            <span>Uplink: Encrypted</span>
        </div>
    </div>

    <div class="flex items-center space-x-6">
        <div class="relative group cursor-pointer">
            <span class="text-xl">🔔</span>
            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-600 rounded-full animate-ping"></span>
        </div>
        <div class="h-6 w-px bg-red-900/50 mx-2"></div>
        <button
            class="text-[10px] font-bold text-red-600 hover:text-red-400 uppercase tracking-tighter transition-colors">
            Terminating Connection [Logout]
        </button>
    </div>
</nav>

@if (session('success') || (isset($globalSettings->maintenance_message) && $globalSettings->maintenance_message))
    <div id="tactical-hud-alert"
        class="fixed top-20 right-8 z-[100] w-96 transform transition-all duration-700 translate-x-[150%] opacity-0">

        <div
            class="bg-black/95 border-l-4 border-red-600 border-y border-r border-red-900/40 p-5 shadow-[0_0_50px_rgba(153,0,0,0.3)] backdrop-blur-xl">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 pt-1">
                    <span class="text-red-600 animate-pulse text-2xl">📡</span>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-[10px] font-black text-red-600 uppercase tracking-[0.3em]">
                            Priority_Transmission
                        </div>
                        {{-- ปุ่มปิด (X) มุมบน --}}
                        <button onclick="terminateAlert()"
                            class="text-red-900 hover:text-red-500 transition-colors text-lg font-bold">×</button>
                    </div>

                    <div
                        class="text-sm text-gray-200 font-mono leading-relaxed bg-red-900/5 p-3 border border-red-900/20 italic mb-4">
                        "{{ session('success') ?? $globalSettings->maintenance_message }}"
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="text-[8px] text-red-900 uppercase font-bold tracking-widest flex items-center">
                            <span class="w-1 h-1 bg-red-600 rounded-full mr-2 animate-ping"></span>
                            Waiting_for_Acknowledge...
                        </div>

                        {{-- ปุ่มกดปิดแบบยุทธวิธี --}}
                        <button onclick="terminateAlert()"
                            class="bg-red-600/10 hover:bg-red-600 hover:text-black border border-red-600 px-4 py-1 text-[10px] font-black uppercase tracking-widest transition-all active:scale-90">
                            Acknowledge [X]
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertBox = document.getElementById('tactical-hud-alert');

            if (alertBox) {
                // 🚀 ปรากฏตัวจากความมืด
                setTimeout(() => {
                    alertBox.classList.remove('translate-x-[150%]', 'opacity-0');
                    alertBox.classList.add('translate-x-0', 'opacity-100');
                }, 300);
            }
        });

        // ฟังก์ชันสั่งปิดด้วยมือ
        function terminateAlert() {
            const alertBox = document.getElementById('tactical-hud-alert');

            // 💣 ถอยกลับและจางหายไป
            alertBox.classList.add('translate-x-[150%]', 'opacity-0');

            // ลบออกจากโครงสร้างหลังจากแอนิเมชันจบ
            setTimeout(() => {
                alertBox.remove();
            }, 700);
        }
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- 🛡️ ติดตั้งระบบแจ้งเตือนจากไฟล์ภายนอก --}}
@include('components.tactical-alert')
