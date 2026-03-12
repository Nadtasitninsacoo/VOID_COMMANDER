/**
 * VOID_COMMANDER - Operative Management Logic
 * Strategic Form Switching (Create/Edit)
 */

function editOperative(id) {
    // 📡 ยิงสัญญาณดึงข้อมูลจากระบบฐานข้อมูล
    fetch(`/admin/operatives/${id}/json`)
        .then(response => {
            if (!response.ok) throw new Error('NETWORK_SIGNAL_LOST');
            return response.json();
        })
        .then(data => {
            // 🎯 กำหนดเป้าหมาย Element
            const form = document.querySelector('#operative-form');
            const container = document.querySelector('#form-container');
            const submitBtn = document.querySelector('#submit-button');
            const titleLabel = document.querySelector('#form-title');
            const cancelBtn = document.querySelector('#cancel-edit');
            const passwordField = document.querySelector('#password-field');

            // 1. บรรจุข้อมูลเข้าสู่ Input (Data Injection)
            document.querySelector('#input-name').value = data.name;
            document.querySelector('#input-username').value = data.username;
            document.querySelector('#input-level').value = data.level;

            // 2. เปลี่ยนเส้นทางยุทธการ (Action & Method)
            form.action = `/admin/operatives/${id}`;
            ensurePutMethod(form);

            // 3. ปรับสถานะ UI (Visual Override)
            // เปลี่ยนสีขอบและเงาเป็นสีน้ำเงิน
            container.classList.remove('border-red-600', 'shadow-[0_0_40px_rgba(220,38,38,0.1)]');
            container.classList.add('border-blue-500', 'shadow-[0_0_40px_rgba(59,130,246,0.2)]');

            // เปลี่ยนข้อความหัวข้อ
            titleLabel.innerText = '✎ Edit_Operative';
            titleLabel.parentElement.classList.replace('text-red-500', 'text-blue-500');

            // ปรับปุ่ม Submit
            submitBtn.innerText = 'UPDATE_RECORD';
            submitBtn.classList.replace('bg-red-600', 'bg-blue-600');
            submitBtn.classList.replace('hover:bg-red-500', 'hover:bg-blue-500');

            // แสดงปุ่มยกเลิก และซ่อนช่องรหัสผ่าน (เพื่อความปลอดภัย)
            cancelBtn.classList.remove('hidden');
            if (passwordField) passwordField.classList.add('hidden');

            // Scroll กลับไปที่ฟอร์มเพื่อให้ท่านจอมพลแก้ไขได้ทันที
            container.scrollIntoView({ behavior: 'smooth' });
        })
        .catch(error => console.error('CRITICAL_ERROR:', error));
}

function ensurePutMethod(form) {
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        methodInput.value = 'PUT';
    }
}