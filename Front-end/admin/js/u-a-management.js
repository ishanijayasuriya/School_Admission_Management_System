document.addEventListener('DOMContentLoaded', function () {
    const userAvatar = document.getElementById('userAvatar');
    const profileForm = document.getElementById('profileForm');

    loadProfile(); // Load from backend

    document.getElementById('photoInput').addEventListener('change', handlePhotoUpload);
    document.getElementById('firstName').addEventListener('input', updateAvatarInitials);
    document.getElementById('lastName').addEventListener('input', updateAvatarInitials);

    profileForm.addEventListener('submit', function (e) {
        e.preventDefault();
        saveProfile(); // Save to backend
    });
});

function uploadPhoto() {
    document.getElementById('photoInput').click();
}

function handlePhotoUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const photoBase64 = e.target.result;
            document.getElementById('userAvatar').style.backgroundImage = `url(${photoBase64})`;
            document.getElementById('userAvatar').textContent = '';
            localStorage.setItem('profilePhoto', photoBase64);
        };
        reader.readAsDataURL(file);
    }
}

function updateAvatarInitials() {
    const first = document.getElementById('firstName').value;
    const last = document.getElementById('lastName').value;
    const initials = (first[0] || '') + (last[0] || '');
    const userAvatar = document.getElementById('userAvatar');
    if (!localStorage.getItem('profilePhoto')) {
        userAvatar.textContent = initials.toUpperCase();
        userAvatar.style.backgroundImage = '';
    }
}

function saveProfile() {
    const profileData = {
        firstName: document.getElementById('firstName').value,
        lastName: document.getElementById('lastName').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        dateOfBirth: document.getElementById('dateOfBirth').value,
        gender: document.getElementById('gender').value,
        address: document.getElementById('address').value,
        photo: localStorage.getItem('profilePhoto') || null
    };

    fetch('../../backend/user/save_profile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(profileData)
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(' Profile saved successfully!');
            } else {
                alert(' Error: ' + data.error);
            }
        })
        .catch(err => {
            console.error('Error saving profile:', err);
            alert('Network error.');
        });
}

function loadProfile() {
    fetch('../../backend/user/load_profile.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const profile = data.profile;
                document.getElementById('firstName').value = profile.first_name || '';
                document.getElementById('lastName').value = profile.last_name || '';
                document.getElementById('email').value = profile.email || '';
                document.getElementById('phone').value = profile.phone || '';
                document.getElementById('dateOfBirth').value = profile.date_of_birth || '';
                document.getElementById('gender').value = profile.gender || '';
                document.getElementById('address').value = profile.address || '';

                if (profile.photo) {
                    localStorage.setItem('profilePhoto', profile.photo);
                    document.getElementById('userAvatar').style.backgroundImage = `url(${profile.photo})`;
                    document.getElementById('userAvatar').textContent = '';
                } else {
                    updateAvatarInitials();
                }
            } else {
                alert('Failed to load profile.');
            }
        })
        .catch(err => {
            console.error('Error loading profile:', err);
        });
}

function resetProfile() {
    document.getElementById('profileForm').reset();
    localStorage.removeItem('profilePhoto');
    updateAvatarInitials();
}
