/**
 * VOID_COMMANDER: CENTRAL CONTROL PROTOCOL (Updated)
 * จัดการทุกการเคลื่อนไหวผ่าน JS ระบบเดียว
 */

document.addEventListener('DOMContentLoaded', () => {

    // === 1. PROTOCOL: EXIT & DASHBOARD === (โค้ดเดิมของท่าน)
    const exitBtn = document.getElementById('exit-protocol-btn');
    if (exitBtn) {
        exitBtn.onclick = (e) => {
            e.preventDefault();
            console.log("กำลังส่งสัญญาณถอนตัวและวาร์ปกลับหน้าหลัก...");
            // ... (fetch logic เดิม)
            window.location.href = '/';
        };
    }

    // === 2. PROTOCOL: NAVIGATE (เพิ่มลูกข่าย) === (โค้ดเดิมของท่าน)
    const addOpBtn = document.getElementById('add-operative-btn');
    if (addOpBtn) {
        addOpBtn.onclick = (e) => {
            e.preventDefault();
            const targetUrl = addOpBtn.getAttribute('data-url') || '/operatives/create';
            window.location.href = targetUrl;
        };
    }

    // === 3. PROTOCOL: CONFIGURATION === (โค้ดเดิมของท่าน)
    const configBtn = document.getElementById('config-protocol-btn');
    if (configBtn) {
        configBtn.onclick = (e) => {
            e.preventDefault();
            console.log("กำลังเข้าสู่ศูนย์ควบคุมนโยบายระบบ...");
            const targetUrl = configBtn.getAttribute('data-url') || '/admin/configuration';
            window.location.href = targetUrl;
        };
    }

    // === 4. PROTOCOL: VULN_SCANNER (เข้าสู่ระบบสแกน F-22) ===
    const vulnBtn = document.getElementById('vuln-scanner-btn');
    if (vulnBtn) {
        vulnBtn.onclick = (e) => {
            e.preventDefault();

            // 📡 สร้างเอฟเฟกต์ Terminal Feedback
            console.log("ALERT: กำลังสถาปนาการเชื่อมต่อกับระบบเล็งเป้า F-22 Raptor...");

            // ดึง URL จาก data-url
            const targetUrl = vulnBtn.getAttribute('data-url');

            // 🛡️ ปฏิบัติการ "Glitch Effect" ก่อนเปลี่ยนหน้า (Optional)
            document.body.style.opacity = '0.5';

            setTimeout(() => {
                window.location.href = targetUrl;
            }, 150); // ดีเลย์เล็กน้อยเพื่อให้รู้สึกถึงการประมวลผลทางทหาร
        };
    }

    // === 5. PROTOCOL: KILL_CHAIN (เข้าสู่ศูนย์บัญชาการยิงเชิงรุก) ===
    const killChainBtn = document.getElementById('kill-chain-btn');
    if (killChainBtn) {
        killChainBtn.onclick = (e) => {
            e.preventDefault();

            // 📡 ส่งสัญญาณไปยัง Console ของจอมพล
            console.log("💀 WARNING: กำลังปลดล็อกสลักนิรภัย และเข้าสู่ระบบ KILL_CHAIN_STRIKE...");

            // ดึงพิกัด URL จาก data-url
            const targetUrl = killChainBtn.getAttribute('data-url');

            // 🚨 ปฏิบัติการ "Red Alert Glitch" (หน้าจอมืดลงและเปลี่ยนสีเป็นโทนแดง)
            document.body.style.filter = "brightness(0.6) sepia(1) saturate(3) hue-rotate(-50deg)";
            document.body.style.transition = "all 0.3s ease-in-out";

            setTimeout(() => {
                window.location.href = targetUrl;
            }, 300); // ดีเลย์เพื่อสร้างจังหวะกระชากก่อนเข้าหน้ายิง
        };
    }

    // --- [ Intelligence Protocol Execution ] ---
    const intelBtn = document.getElementById('intelligence-btn');
    if (intelBtn) {
        intelBtn.addEventListener('click', function () {
            const url = this.getAttribute('data-url');

            // ท่านจอมพลสามารถใส่ Effect เสียงหรือ Loading ก่อนเปลี่ยนหน้าได้ที่นี่
            console.log(">> INITIALIZING_SIGNAL_INTERCEPT_DASHBOARD...");

            window.location.href = url;
        });
    }
});

function initiateExit(targetUrl, welcomeUrl, token) {
    console.log("กำลังส่งสัญญาณถอนตัวไปยังศูนย์กลาง...");

    fetch(targetUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({
            action: "exit_to_welcome",
            status: "authorized"
        })
    })
        .then(response => {
            if (response.ok) {
                // ปฏิบัติการเปลี่ยนหน้าทันทีเมื่อหลังบ้านตอบรับ
                window.location.href = welcomeUrl;
            } else {
                console.error("ระบบส่วนกลางไม่อนุมัติ (Status: " + response.status + ")");
                alert("คำเตือน: ระบบไม่อนุมัติการถอนตัวในขณะนี้");
            }
        })
        .catch(error => {
            console.error("สัญญาณรบกวนขัดขวางการเชื่อมต่อ:", error);
        });
}