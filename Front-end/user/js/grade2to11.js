document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('admissionForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            // Validate required fields
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#e74c3c';
                    isValid = false;
                } else {
                    field.style.borderColor = '';
                }
            });
            
            // Validate date of birth
            const year = form.querySelector('input[name="birthYear"]');
            const month = form.querySelector('select[name="birthMonth"]');
            const day = form.querySelector('input[name="birthDay"]');
            
            if (year && month && day) {
                if (!isValidDate(parseInt(year.value), parseInt(month.value), parseInt(day.value))) {
                    year.style.borderColor = '#e74c3c';
                    month.style.borderColor = '#e74c3c';
                    day.style.borderColor = '#e74c3c';
                    isValid = false;
                    alert('Please enter a valid date of birth');
                }
            }
            
            // Validate telephone number
            const phone = form.querySelector('input[name="applicantPhone"]');
            if (phone && !/^[0-9+]{10,15}$/.test(phone.value)) {
                phone.style.borderColor = '#e74c3c';
                isValid = false;
                alert('Please enter a valid telephone number');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill all required fields correctly');
            }
        });
    }
    
    // Auto-calculate age based on date of birth
    const dobInputs = form.querySelectorAll('input[name="birthYear"], select[name="birthMonth"], input[name="birthDay"]');
    const ageYearInput = form.querySelector('input[name="ageYear"]');
    const ageInputs = form.querySelectorAll('input[name="ageYears"], input[name="ageMonths"], input[name="ageDays"]');
    
    if (dobInputs.length && ageInputs.length && ageYearInput) {
        dobInputs.forEach(input => {
            input.addEventListener('change', calculateAge);
        });
    }
    
    function calculateAge() {
        const year = parseInt(form.querySelector('input[name="birthYear"]').value);
        const month = parseInt(form.querySelector('select[name="birthMonth"]').value);
        const day = parseInt(form.querySelector('input[name="birthDay"]').value);
        const ageYear = parseInt(ageYearInput.value) || new Date().getFullYear();
        
        if (year && month && day && ageYear) {
            const birthDate = new Date(year, month - 1, day);
            const cutoffDate = new Date(ageYear, 0, 31); // January 31st of the age year
            
            let ageYears = cutoffDate.getFullYear() - birthDate.getFullYear();
            let ageMonths = cutoffDate.getMonth() - birthDate.getMonth();
            let ageDays = cutoffDate.getDate() - birthDate.getDate();
            
            if (ageDays < 0) {
                ageMonths--;
                const lastDayOfMonth = new Date(
                    cutoffDate.getFullYear(),
                    cutoffDate.getMonth(),
                    0
                ).getDate();
                ageDays += lastDayOfMonth;
            }
            
            if (ageMonths < 0) {
                ageYears--;
                ageMonths += 12;
            }
            
            form.querySelector('input[name="ageYears"]').value = ageYears;
            form.querySelector('input[name="ageMonths"]').value = ageMonths;
            form.querySelector('input[name="ageDays"]').value = ageDays;
        }
    }
    
    function isValidDate(year, month, day) {
        if (isNaN(year) || isNaN(month) || isNaN(day)) return false;
        if (year < 1900 || year > new Date().getFullYear()) return false;
        if (month < 1 || month > 12) return false;
        
        const date = new Date(year, month - 1, day);
        return date.getFullYear() === year && 
               date.getMonth() === month - 1 && 
               date.getDate() === day;
    }
    
    // Format telephone number input
    const phoneInput = document.querySelector('input[name="applicantPhone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }
    
    // Show/hide category sections based on selection
    // This would need to be implemented based on your specific category selection logic
});