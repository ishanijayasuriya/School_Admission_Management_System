document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('schoolForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // prevent actual form submission

        // Collect form data into an object
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value.trim();
        });

        // Simple validation example
        if (!data.fullName || !data.nameWithInitials || !data.telephone) {
            alert('Please fill in all required fields like Full Name, Name with Initials, and Telephone.');
            return;
        }

        // Optionally log data to check
        console.log('Form Submitted:', data);

        // Example: Save to localStorage (temporary front-end storage)
        localStorage.setItem('schoolFormData', JSON.stringify(data));

        // Show success message
        alert('Application submitted successfully!');

        // Optionally reset form
        form.reset();
    });
});
