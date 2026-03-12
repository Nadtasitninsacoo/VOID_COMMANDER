/**
 * 🛰️ VOID_COMMANDER - Global Command Terminal JS
 * ระบบจัดการการแจ้งเตือนและการตอบสนองทั่วทั้งระบบ
 */

document.addEventListener('DOMContentLoaded', function () {

    // 🛡️ 1. ตั้งค่ามาตรฐานของ Toast (การแจ้งเตือนมุมจอ)
    const TacticalToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#050505',
        color: '#d1d5db',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // 📡 2. ดักรับสัญญาณจาก Hidden Inputs (ที่ส่งมาจาก Controller)
    const success = document.getElementById('signal-success')?.value;
    const error = document.getElementById('signal-error')?.value;
    const validation = document.getElementById('signal-validation')?.value;

    if (success) {
        TacticalToast.fire({
            icon: 'success',
            title: success,
            iconColor: '#dc2626'
        });
    }

    if (error) {
        Swal.fire({
            title: 'CRITICAL_ERROR',
            text: error,
            icon: 'error',
            background: '#0a0a0a',
            color: '#d1d5db',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'ACKNOWLEDGE'
        });
    }

    if (validation) {
        TacticalToast.fire({
            icon: 'warning',
            title: validation,
            iconColor: '#facc15'
        });
    }
});

/**
 * 💀 3. ฟังก์ชันยืนยันปฏิบัติการ (Universal Confirmation)
 * ใช้เรียกผ่าน onsubmit="return confirmTacticalAction(event, this, 'ข้อความยืนยัน')"
 */
function confirmTacticalAction(event, form, message = "ยืนยันการดำเนินการยุทธวิธี?") {
    event.preventDefault(); // ระงับการส่งข้อมูลชั่วคราว

    Swal.fire({
        title: 'TACTICAL_CONFIRMATION',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        background: '#0a0a0a',
        color: '#d1d5db',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#1f2937',
        confirmButtonText: 'PROCEED',
        cancelButtonText: 'ABORT',
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // ส่งข้อมูลเมื่อท่านจอมพลยืนยัน
        }
    });
    return false;
}