document.getElementById('admissionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = document.getElementById('admissionForm');
    const formData = new FormData(form);

    fetch('../../backend/user/grade_6_process_form.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Application submitted successfully!");
            window.location.href = "../Front-end/user/dashboard.html";
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => {
        alert("Submission failed!");
        console.error(error);
    });
});
