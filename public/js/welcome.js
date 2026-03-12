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