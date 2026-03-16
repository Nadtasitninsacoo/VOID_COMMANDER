/**
 * KILL_CHAIN_STRIKE EXTERNAL_LOGIC_v1.0
 */

// ฟังก์ชันสำหรับเลือกอาวุธ (Global Scope เพื่อให้เรียกจาก inline onclick ได้)
window.setPayload = function (code, id, name) {
    const payloadArea = document.getElementById('payload_area');
    const weaponInput = document.getElementById('selected_weapon_id');
    const log = document.getElementById('terminal_logs');

    if (payloadArea) payloadArea.value = code;
    if (weaponInput) weaponInput.value = id;

    if (log) {
        log.innerHTML += `<p class="text-yellow-600">[${new Date().toLocaleTimeString()}] WEAPON_SYSTEM_ARMED: ${name} (${id}) Loaded.</p>`;
        log.scrollTop = log.scrollHeight;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const strikeForm = document.getElementById('strikeForm');
    const log = document.getElementById('terminal_logs');

    if (!strikeForm) return;

    strikeForm.onsubmit = async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const weaponId = document.getElementById('selected_weapon_id').value;

        // ตรวจสอบว่าเลือกอาวุธหรือยัง
        if (!weaponId) {
            log.innerHTML += `<p class="text-red-400">[${new Date().toLocaleTimeString()}] WARNING: No weapon system selected!</p>`;
            return;
        }

        const payloadData = {
            target: formData.get('target'),
            weapon_id: weaponId,
            thread_count: formData.get('thread_count'),
            _token: window.StrikeConfig.csrfToken // ใช้ Token จาก Config
        };

        log.innerHTML += `<p class="text-red-600 animate-pulse">[${new Date().toLocaleTimeString()}] INITIALIZING_STRIKE: Dispatching to WSL Engine...</p>`;
        log.scrollTop = log.scrollHeight;

        try {
            const response = await fetch(window.StrikeConfig.executeRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.StrikeConfig.csrfToken
                },
                body: JSON.stringify(payloadData)
            });

            const result = await response.json();

            if (result.status === 'SUCCESS') {
                log.innerHTML += `<p class="text-green-500">[${new Date().toLocaleTimeString()}] STRIKE_SUCCESS: ${result.message}</p>`;
                log.innerHTML += `<div class="text-gray-500 pl-4 border-l border-gray-800 my-2 bg-red-950/5 p-2 whitespace-pre-wrap font-mono">${result.raw_log}</div>`;
            } else {
                log.innerHTML += `<p class="text-red-400">[${new Date().toLocaleTimeString()}] STRIKE_ERROR: ${result.message}</p>`;
            }
        } catch (error) {
            log.innerHTML += `<p class="text-red-800">[${new Date().toLocaleTimeString()}] SYSTEM_CRITICAL: Connection to Controller Failed.</p>`;
        }

        log.scrollTop = log.scrollHeight;
    };
});
