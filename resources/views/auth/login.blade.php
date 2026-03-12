<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOID_COMMANDER | LOGIN_TERMINAL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#050505] text-gray-300 min-h-screen w-full font-['JetBrains_Mono'] overflow-hidden">

    <x-sidebar />
    <x-navbar />

    <canvas id="matrix-canvas" style="background: #050505;"
        class="fixed inset-0 z-[-1] opacity-30 pointer-events-none"></canvas>

    <div class="scanline z-10"></div>

    <main class="ml-64 min-h-screen flex items-center justify-center p-8 relative z-20">

        <div class="w-full max-w-[420px] relative font-sans">
            <div class="absolute inset-0 m-auto w-[300px] h-[300px] bg-red-900/20 blur-[130px] rounded-full"></div>

            <div
                class="relative bg-black border border-red-600/30 p-10 rounded-[2.5rem] shadow-[0_0_100px_rgba(255,0,0,0.1)] overflow-hidden">

                <div
                    class="absolute inset-0 flex items-center justify-center opacity-[0.08] pointer-events-none select-none z-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-80 h-80 fill-red-700">
                        <path
                            d="M224 480c-132.5 0-240-107.5-240-240S91.5 0 224 0s240 107.5 240 240-107.5 240-240 240zm0-360c-66.3 0-120 53.7-120 120s53.7 120 120 120 120-53.7 120-120-53.7-120-120-120zm0 184c-35.3 0-64-28.7-64-64s28.7-64 64-64 64 28.7 64 64-28.7 64-64 64z" />
                    </svg>
                </div>

                <div class="relative z-10 text-center mb-10">
                    <div class="inline-block px-4 py-1 bg-red-950 border border-red-600/50 rounded-full mb-4">
                        <span
                            class="text-[10px] text-red-500 font-black tracking-[0.3em] uppercase animate-pulse">สถานะ:
                            ปิดตายระบบภายนอก</span>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-2 tracking-tighter">
                        ศูนย์บัญชาการหลัก
                    </h3>
                    <p class="text-[10px] text-red-600/60 font-bold tracking-[0.4em]">การเข้าถึงถูกจำกัดโดยจอมพลเท่านั้น
                    </p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="relative z-10 space-y-7">
                    @csrf
                    <div class="space-y-6">
                        <div class="relative group">
                            <label
                                class="absolute -top-3 left-6 bg-black px-3 text-[10px] text-red-600 font-black uppercase tracking-widest z-10 border border-red-900/50 rounded-full">
                                อัตลักษณ์ผู้บัญชาการ
                            </label>
                            <input type="text" name="username"
                                class="w-full bg-red-950/10 border border-red-900/60 px-6 py-4 rounded-2xl text-sm text-red-500 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600/40 transition-all placeholder-red-900/30"
                                placeholder="ระบุรหัสเข้าถึง" required autofocus>
                        </div>

                        <div class="relative group">
                            <label
                                class="absolute -top-3 left-6 bg-black px-3 text-[10px] text-red-600 font-black uppercase tracking-widest z-10 border border-red-900/50 rounded-full">
                                กุญแจยืนยันอำนาจ
                            </label>
                            <input type="password" name="password"
                                class="w-full bg-red-950/10 border border-red-900/60 px-6 py-4 rounded-2xl text-sm text-red-500 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600/40 transition-all placeholder-red-900/30"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <button
                        class="relative w-full py-5 group/btn overflow-hidden transition-all duration-300 active:scale-[0.95] outline-none rounded-2xl border border-red-600/60 bg-red-950/20">
                        <div
                            class="absolute inset-0 bg-red-600 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-500">
                        </div>
                        <span
                            class="relative flex items-center justify-center text-red-600 group-hover/btn:text-black font-black tracking-[0.6em] text-[14px] transition-colors duration-500">
                            ยืนยันอำนาจ
                        </span>
                    </button>
                </form>

                <div class="relative z-10 mt-10 text-center border-t border-red-900/40 pt-6">
                    <p class="text-red-700/80 text-[9px] font-bold uppercase tracking-[0.2em] leading-relaxed">
                        คำเตือน: การพยายามเข้าถึงโดยไม่ได้รับอนุญาต<br>จะถูกตรวจจับและกำจัดโดยระบบอัตโนมัติ
                    </p>
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-0 left-64 right-0 z-30">
        <x-footer />
    </div>

    <script>
        // ใช้ฟังก์ชันที่ทำงานทันทีโดยไม่รอ DOM หาก Script อยู่ท้ายไฟล์อยู่แล้ว
        (function() {
            const canvas = document.getElementById('matrix-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            let width, height, columns;
            let drops = [];
            const fontSize = 16; // ปรับขนาดตัวอักษรให้ชัดขึ้น
            const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789VOIDCOMMANDER";

            function initCanvas() {
                // ใช้ค่าจาก ClientWidth เพื่อความแม่นยำในบาง Browser
                width = window.innerWidth;
                height = window.innerHeight;
                canvas.width = width;
                canvas.height = height;

                columns = Math.floor(width / fontSize);
                drops = [];
                for (let i = 0; i < columns; i++) {
                    // สุ่มจุดเริ่มต้นให้กระจายทั่วจอ
                    drops[i] = Math.random() * (height / fontSize);
                }
            }

            function draw() {
                // สร้างหางของสายฝนด้วยสีดำจางๆ
                ctx.fillStyle = "rgba(5, 5, 5, 0.1)";
                ctx.fillRect(0, 0, width, height);

                // สีแดง Tactical
                ctx.fillStyle = "#ff0000";
                ctx.font = "bold " + fontSize + "px 'JetBrains Mono'";

                for (let i = 0; i < drops.length; i++) {
                    const text = letters.charAt(Math.floor(Math.random() * letters.length));

                    // สุ่มความสว่างเพื่อให้สายฝนดูมีมิติ
                    if (Math.random() > 0.9) {
                        ctx.fillStyle = "#ff5555"; // หัวสายฝนที่สว่างกว่า
                    } else {
                        ctx.fillStyle = "#FF0000"; // หางสายฝนที่มืดกว่า
                    }

                    ctx.fillText(text, i * fontSize, drops[i] * fontSize);

                    if (drops[i] * fontSize > height && Math.random() > 0.975) {
                        drops[i] = 0;
                    }
                    drops[i]++;
                }
            }

            initCanvas();
            // ปรับความเร็วให้ดูสมูทขึ้น (30fps)
            const matrixInterval = setInterval(draw, 33);

            window.addEventListener('resize', () => {
                initCanvas();
            });
        })();
    </script>
</body>

</html>
