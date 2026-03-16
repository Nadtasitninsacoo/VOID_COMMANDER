/**
 * 💀 KILL_CHAIN_CORE_SYSTEM (Optimized for Render)
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
            
            // ดึง Token จาก Config หรือ Input ก็ได้ แต่ต้องมั่นใจว่ามีค่า
            const csrfToken = window.StrikeConfig?.csrfToken || document.querySelector('input[name="_token"]')?.value;

            if (!target || !window.selectedWeaponId) {
                log.innerHTML += `<p class="text-orange-500">[${new Date().toLocaleTimeString()}] ⚠️ WARNING: พิกัดเป้าหมายหรืออาวุธยังไม่ถูกติดตั้ง</p>`;
                return;
            }

            log.innerHTML += `<p class="text-red-600 animate-pulse">[${new Date().toLocaleTimeString()}] 🚀 INITIALIZING_STRIKE: Connecting to -> ${target}</p>`;

            // ใช้ Route จาก Config เพื่อป้องกันปัญหา Path ผิดพลาดบน Render
            const executeUrl = window.StrikeConfig?.executeRoute || "/admin/kill-chain/execute";

            fetch(executeUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    target: target,
                    weapon_id: window.selectedWeaponId
                })
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP_ERROR: ${response.status}`);
                return response.json();
            })
            .then(data => {
                // ... ส่วนแสดงผล SUCCESS / FAILED เหมือนเดิมของท่าน ...
                log.scrollTop = log.scrollHeight;
            })
            .catch(error => {
                log.innerHTML += `<p class="text-red-800">[${new Date().toLocaleTimeString()}] 🚨 SYSTEM_CRITICAL: ${error.message}</p>`;
                log.scrollTop = log.scrollHeight;
            });
        };
    }
});
