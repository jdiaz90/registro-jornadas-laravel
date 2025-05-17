document.addEventListener('DOMContentLoaded', () => {
    // Obtenemos los elementos necesarios
    const textarea = document.getElementById('modification_reason');
    const charCount = document.getElementById('charCount');
    
    // Plantilla de contador usando etiquetas de idioma.
    // Puedes pasar una plantilla desde Blade (por ejemplo, definiéndolo como una variable global desde la vista)
    // Para este ejemplo usaremos un fallback.
    const charCountTemplate = window.charCountTemplate || ':count/:max characters';

    function formatCharCount(count, max) {
        return charCountTemplate.replace(':count', count).replace(':max', max);
    }

    function updateCharCount() {
        if (!textarea || !charCount) return;
        const count = textarea.value.length;
        charCount.textContent = formatCharCount(count, 255);
        charCount.style.color = count >= 220 ? 'red' : 'gray';
    }

    if (textarea) {
        updateCharCount();
        textarea.addEventListener('input', updateCharCount);
    }

    // Función para calcular las horas y actualizar los campos correspondientes.
    function calculateHours() {
        const checkInElem  = document.getElementById('check_in');
        const checkOutElem = document.getElementById('check_out');
        const pauseStartElem = document.getElementById('pause_start');
        const pauseEndElem   = document.getElementById('pause_end');
        const pauseMinutesField = document.getElementById('pause_minutes');
        const ordinaryHoursField = document.getElementById('ordinary_hours');
        const complementaryHoursField = document.getElementById('complementary_hours');
        const overtimeHoursField = document.getElementById('overtime_hours');

        if (!checkInElem || !checkOutElem) return;
        const checkIn = new Date(checkInElem.value);
        const checkOut = new Date(checkOutElem.value);
        const workedMinutes = Math.abs((checkOut - checkIn) / 60000);

        let pauseMinutes = 0;
        if (pauseStartElem && pauseEndElem && pauseStartElem.value && pauseEndElem.value) {
            const pauseStart = new Date(pauseStartElem.value);
            const pauseEnd   = new Date(pauseEndElem.value);
            pauseMinutes = Math.abs((pauseEnd - pauseStart) / 60000);
        }
        if(pauseMinutesField) {
            pauseMinutesField.value = Math.round(pauseMinutes);
        }

        const netWorkedMinutes = workedMinutes - pauseMinutes;
        const assignedMinutes  = 7 * 60; // 420 minutos
        let ordinaryHours = 0,
            complementaryHours = 0,
            overtimeHours = 0;

        // El tipo de contrato puede pasarse vía atributo data en el body o en algún elemento.
        // Por ejemplo, podrías definir <body data-contract-type="{{ $workLog->user->contract_type }}">
        const contractType = document.body.getAttribute('data-contract-type') || 'fulltime';

        if (netWorkedMinutes <= assignedMinutes) {
            ordinaryHours = netWorkedMinutes / 60;
        } else {
            ordinaryHours = assignedMinutes / 60;
            const extraMinutes = netWorkedMinutes - assignedMinutes;
            if (contractType === 'fulltime') {
                overtimeHours = extraMinutes / 60;
            } else {
                complementaryHours = extraMinutes / 60;
            }
        }

        if (ordinaryHoursField) ordinaryHoursField.value = ordinaryHours.toFixed(2);
        if (complementaryHoursField) complementaryHoursField.value = complementaryHours.toFixed(2);
        if (overtimeHoursField) overtimeHoursField.value = overtimeHours.toFixed(2);
    }

    // Agregar event listeners a los campos relevantes
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const pauseStartInput = document.getElementById('pause_start');
    const pauseEndInput = document.getElementById('pause_end');

    if(checkInInput) checkInInput.addEventListener('input', calculateHours);
    if(checkOutInput) checkOutInput.addEventListener('input', calculateHours);
    if(pauseStartInput) pauseStartInput.addEventListener('input', calculateHours);
    if(pauseEndInput) checkOutInput.addEventListener('input', calculateHours);
});
