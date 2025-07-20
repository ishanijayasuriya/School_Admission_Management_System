 document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const roleSelect = document.querySelector('select[name="role"]');
    const studentNameInput = document.querySelector('[name="student_name"]');
    const studentDobInput = document.querySelector('[name="student_dob"]');
    const studentFields = [studentNameInput, studentDobInput];

    toggleStudentFields();

    roleSelect.addEventListener('change', toggleStudentFields);

    function toggleStudentFields() {
        const show = ['parent', 'ministry_staff'].includes(roleSelect.value);
        studentFields.forEach(input => {
            input.required = show;
            const container = input.closest('div') || input.parentElement;
            if (container) container.style.display = show ? 'block' : 'none';
        });
    }

    function generateUserID(role) {
        const prefix = {
            parent: 'PAR',
            school_admin: 'ADM',
            ministry_staff: 'STU'
        }[role] || 'USR';

        const timestamp = Date.now().toString().slice(-6);
        const random = Math.floor(1000 + Math.random() * 9000);
        return `${prefix}-${timestamp}-${random}`;
    }

    function validatePassword(pw) {
        return pw.length >= 8 &&
            /[A-Z]/.test(pw) &&
            /\d/.test(pw) &&
            /[!@#$%^&*(),.?":{}|<>]/.test(pw);
    }

    function validatePhone(phone) {
        return /^[0-9]{10}$/.test(phone);
    }

    function validateDOB(dob) {
        const birth = new Date(dob);
        const today = new Date();
        today.setFullYear(today.getFullYear() - 5);
        return birth <= today;
    }

    function showError(message, input) {
        const error = document.createElement('div');
        error.className = 'error';
        error.style.color = 'red';
        error.style.fontSize = '0.8em';
        error.textContent = message;
        input.insertAdjacentElement('afterend', error);
    }

    function clearErrors() {
        document.querySelectorAll('.error').forEach(e => e.remove());
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        if (!validatePassword(data.password)) {
            showError('Password must have 8+ chars, 1 uppercase, 1 number, 1 special char', form.querySelector('[name="password"]'));
            return;
        }

        if (data.password !== data.confirm_password) {
            showError('Passwords do not match', form.querySelector('[name="confirm_password"]'));
            return;
        }

        if (!validatePhone(data.phone)) {
            showError('Phone number must be 10 digits', form.querySelector('[name="phone"]'));
            return;
        }

        if (['parent', 'ministry_staff'].includes(data.role)) {
            if (!data.student_name.trim()) {
                showError('Student name is required', studentNameInput);
                return;
            }

            if (!validateDOB(data.student_dob)) {
                showError('Student must be at least 5 years old', studentDobInput);
                return;
            }
        }

        const userId = generateUserID(data.role);
        formData.append('generated_id', userId);

        fetch('../backend/register_process.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                form.innerHTML = `
                    <div class="success-message">
                        <h3>Registration Successful!</h3>
                        <p><strong>User ID:</strong> ${result.data.system_id}</p>
                        <p><strong>Username:</strong> ${result.data.username}</p>
                        <p><strong>Role:</strong> ${result.data.role}</p>
                        <p>An email has been sent to: ${result.data.email}</p>
                        <a href="../Front-end/home.html" class="login-link">Go to Hear</a>
                    </div>
                `;
            } else {
                alert('Registration failed:\n' + result.errors.join('\n'));
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Something went wrong. Try again.');
        });
    });
});
