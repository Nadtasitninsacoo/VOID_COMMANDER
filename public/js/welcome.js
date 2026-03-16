document.addEventListener('DOMContentLoaded', () => {
    // 1. ตั้งค่าเริ่มต้นให้ Chart.js
    Chart.defaults.color = '#7f1d1d';
    Chart.defaults.font.family = "'JetBrains Mono'";

    const minimalOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 2500,
            easing: 'easeOutExpo'
        },
        plugins: {
            legend: { display: false }
        }
    };

    // 2. ดึงข้อมูลจาก DOM (ส่งผ่าน data-attributes จาก Blade)
    const levelCtx = document.getElementById('levelChart');
    const statusCtx = document.getElementById('statusChart');

    if (levelCtx) {
        new Chart(levelCtx, {
            type: 'doughnut',
            data: {
                labels: ['LOW_LVL', 'HIGH_LVL'],
                datasets: [{
                    data: [levelCtx.dataset.low, levelCtx.dataset.high],
                    backgroundColor: ['#2b0707', '#ff0000'],
                    hoverBackgroundColor: ['#450a0a', '#ff4d4d'],
                    borderWidth: 1,
                    borderColor: '#660000',
                    offset: 20
                }]
            },
            options: {
                ...minimalOptions,
                cutout: '85%',
            }
        });
    }

    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: ['ACT', 'SBY', 'BLK'],
                datasets: [{
                    data: [statusCtx.dataset.act, statusCtx.dataset.sby, statusCtx.dataset.blk],
                    backgroundColor: (context) => {
                        const ctx = context.chart.ctx;
                        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, '#ff0000');
                        gradient.addColorStop(1, '#330000');
                        return gradient;
                    },
                    borderWidth: 1,
                    borderColor: '#ff0000',
                    borderRadius: 0,
                    barPercentage: 0.4
                }]
            },
            options: {
                ...minimalOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#1a0505', drawBorder: false },
                        ticks: { display: true, font: { size: 8 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' } }
                    }
                }
            }
        });
    }
});

// === 3. ระบบควบคุมคลังอาวุธ (WEAPON CONTROL SYSTEM) ===

// ฟังก์ชันเลือก Payload (ประกาศเป็น Global เพื่อให้ปุ่มใน Blade เรียกใช้ได้)
window.setPayload = function (payload, id, name) {
    const payloadArea = document.getElementById('payload_area');
    const weaponInput = document.getElementById('selected_weapon_id');
    const terminal = document.getElementById('terminal_logs');

    if (payloadArea) {
        payloadArea.value = payload;
        // เอฟเฟกต์กะพริบเมื่อบรรจุอาวุธสำเร็จ
        payloadArea.style.borderColor = '#ff0000';
        setTimeout(() => payloadArea.style.borderColor = '#991b1b80', 500);
    }

    if (weaponInput) weaponInput.value = id;

    if (terminal) {
        const time = new Date().toLocaleTimeString();
        const log = document.createElement('p');
        log.className = 'text-red-500 animate-pulse';
        log.innerHTML = `>> [${time}] SYSTEM_ARMED: ${name} (ID: ${id}) - WAITING_FOR_STRIKE_CONFIRMATION`;
        terminal.insertBefore(log, terminal.firstChild);
    }
};

// ระบบส่งการโจมตี (Strike Execution)
const strikeForm = document.getElementById('strikeForm');
if (strikeForm) {
    strikeForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const terminal = document.getElementById('terminal_logs');
        const target = strikeForm.target.value;
        const payload = strikeForm.payload.value;

        if (!target || !payload) {
            alert('🚩 COMMAND_ERROR: ระบุพิกัดเป้าหมายและอาวุธก่อนทำการยิง!');
            return;
        }

        // แสดงสถานะการยิงบน Terminal
        const log = document.createElement('p');
        log.className = 'text-yellow-500 font-bold';
        log.innerHTML = `>> [${new Date().toLocaleTimeString()}] LAUNCHING_STRIKE -> TARGET: ${target}...`;
        terminal.insertBefore(log, terminal.firstChild);

        try {
            const response = await fetch(window.StrikeConfig.executeRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.StrikeConfig.csrfToken
                },
                body: JSON.stringify({
                    target: target,
                    payload: payload,
                    weapon_id: document.getElementById('selected_weapon_id').value
                })
            });

            const result = await response.json();

            const resLog = document.createElement('p');
            resLog.className = result.success ? 'text-green-500' : 'text-red-600';
            resLog.innerHTML = `>> [RESULT]: ${result.message}`;
            terminal.insertBefore(resLog, terminal.firstChild);

        } catch (error) {
            const errLog = document.createElement('p');
            errLog.className = 'text-red-600 font-black';
            errLog.innerHTML = `>> [FATAL_ERROR]: การเชื่อมต่อฐานบัญชาการขัดข้อง!`;
            terminal.insertBefore(errLog, terminal.firstChild);
        }
    });
}
