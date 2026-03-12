// resources/js/activity-logs.js

let secondsElapsed = 0;

function updateUptime() {
    secondsElapsed++;

    const hrs = String(Math.floor(secondsElapsed / 3600)).padStart(2, '0');
    const mins = String(Math.floor((secondsElapsed % 3600) / 60)).padStart(2, '0');
    const secs = String(secondsElapsed % 60).padStart(2, '0');

    const uptimeString = `${hrs}:${mins}:${secs}`;

    const display = document.getElementById('uptime_clock');
    if (display) {
        display.textContent = uptimeString;
    }
}

// เริ่มทำงานเมื่อโหลดหน้าจอเสร็จ
document.addEventListener('DOMContentLoaded', () => {
    // รันครั้งแรกทันที
    updateUptime();
    // ตั้ง Loop ทุก 1 วินาที
    setInterval(updateUptime, 1000);
});