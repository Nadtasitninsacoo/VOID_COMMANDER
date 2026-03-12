document.addEventListener('DOMContentLoaded', function () {
    const chartFont = { family: 'JetBrains Mono', size: 10 };

    // ตั้งค่าส่วนกลางให้เหมาะกับกล่องขนาดเล็ก
    const minimalOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom', // ย้ายมาไว้ข้างล่างเพื่อไม่ให้เบียดตัวกราฟ
                labels: {
                    color: '#ef4444',
                    font: chartFont,
                    boxWidth: 10,
                    padding: 10
                }
            }
        },
        layout: { padding: 5 }
    };

    // --- 🔴 กราฟวงกลม (Doughnut) ---
    const levelCtx = document.getElementById('operativeLevelChart');
    if (levelCtx) {
        new Chart(levelCtx, {
            type: 'doughnut',
            data: {
                labels: ['LVL_21-50', 'LVL_51-99'],
                datasets: [{
                    data: [25, 10],
                    backgroundColor: ['#991b1b', '#dc2626'],
                    borderColor: '#050505',
                    borderWidth: 2,
                    hoverOffset: 5
                }]
            },
            options: {
                ...minimalOptions,
                cutout: '65%' // ทำให้วงแหวนดูเพรียวบาง
            }
        });
    }

    // --- ⚪ กราฟแท่ง (Bar) ---
    const statusCtx = document.getElementById('operativeStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: ['ACT', 'SBY', 'BLK'], // ใช้ตัวย่อเพื่อให้ประหยัดพื้นที่
                datasets: [{
                    label: 'UNITS',
                    data: [12, 5, 2],
                    backgroundColor: 'rgba(220, 38, 38, 0.5)',
                    borderColor: '#ef4444',
                    borderWidth: 1
                }]
            },
            options: {
                ...minimalOptions,
                scales: {
                    y: {
                        grid: { color: '#2d0a0a' },
                        ticks: { color: '#991b1b', font: chartFont, display: false } // ปิดตัวเลขแกน Y เพื่อให้ดูคลีน
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#991b1b', font: chartFont }
                    }
                }
            }
        });
    }
});