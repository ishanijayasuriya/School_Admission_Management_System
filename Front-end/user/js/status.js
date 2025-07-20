
document.getElementById('email-notification-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const formMessage = document.getElementById('form-message');

    fetch('../../backend/user/subscribe_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            formMessage.innerHTML = `<span style="color: green;">${data.message}</span>`;
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 3000);
        } else {
            formMessage.innerHTML = `<span style="color: red;">${data.message}</span>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        formMessage.innerHTML = `<span style="color: red;">Something went wrong.</span>`;
    });
});
