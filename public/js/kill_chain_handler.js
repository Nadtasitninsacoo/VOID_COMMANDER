/**
 * 💀 KILL_CHAIN_CORE_SYSTEM
 * จัดการการยิง Payload และรับส่งข้อมูลกับ Backend
 */
window.selectedWeaponId = '';

window.setPayload = function (code, id, name) {
    window.selectedWeaponId = id;
    const payloadArea = document.getElementById('payload_area');
    const log = document.getElementById('terminal_logs');

    if (payloadArea) payloadArea.value = code;

    if (log) {
        log.innerHTML += `<p class="text-yellow-600">[${new Date().toLocaleTimeString()}] ⚔️ WEAPON_ARMED: ${name}</p>`;
        log.scrollTop = log.scrollHeight;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const strikeForm = document.getElementById('strikeForm');
    if (strikeForm) {
        strikeForm.onsubmit = function (e) {
            e.preventDefault();

            const target = this.target.value;
            const log = document.getElementById('terminal_logs');
            const csrfToken = document.querySelector('input[name="_token"]').value;

            if (!target || !window.selectedWeaponId) {
                log.innerHTML += `<p class="text-orange-500">[${new Date().toLocaleTimeString()}] ⚠️ WARNING: พิกัดเป้าหมายหรืออาวุธยังไม่ถูกติดตั้ง</p>`;
                return;
            }

            log.innerHTML += `<p class="text-red-600 animate-pulse">[${new Date().toLocaleTimeString()}] 🚀 INITIALIZING_STRIKE: Connecting to -> ${target}</p>`;

            // 📡 ส่งคำสั่งไปยัง Backend (ปรับ URL ให้ตรงกับ Route ของท่าน)
            fetch("/admin/kill-chain/execute", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    target: target,
                    weapon_id: window.selectedWeaponId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'SUCCESS') {
                        log.innerHTML += `
                        <div class="border-l-2 border-green-600 pl-2 my-2 bg-green-900/10">
                            <p class="text-green-400 font-bold">[${new Date().toLocaleTimeString()}] ✅ STRIKE_SUCCESS</p>
                            <p class="text-gray-400 text-[8px]">RESPONSE_CODE: ${data.code}</p>
                            <p class="text-gray-400 text-[8px]">MESSAGE: ${data.message}</p>
                        </div>
                    `;
                    } else {
                        log.innerHTML += `
                        <div class="border-l-2 border-red-600 pl-2 my-2 bg-red-900/10">
                            <p class="text-red-500 font-bold">[${new Date().toLocaleTimeString()}] ❌ STRIKE_FAILED</p>
                            <p class="text-gray-400 text-[8px]">ERROR: ${data.message}</p>
                        </div>
                    `;
                    }
                    log.scrollTop = log.scrollHeight;
                })
                .catch(error => {
                    log.innerHTML += `<p class="text-red-800">[${new Date().toLocaleTimeString()}] 🚨 SYSTEM_CRITICAL: ${error.message}</p>`;
                });
        };
    }
});