 document.addEventListener('DOMContentLoaded', function() {
    const userAvatar = document.getElementById('userAvatar');
    const firstName = document.getElementById('firstName');
    const lastName = document.getElementById('lastName');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const dateOfBirth = document.getElementById('dateOfBirth');
    const gender = document.getElementById('gender');
    const address = document.getElementById('address');

    // Load profile data when page loads
    loadProfile();

    // Add input event listeners for name fields
    firstName.addEventListener('input', updateAvatarInitials);
    lastName.addEventListener('input', updateAvatarInitials);

    // Form submit handler
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveProfile();
    });
});

function uploadPhoto() {
    document.getElementById('photoInput').click();
}

function handlePhotoUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const profileData = JSON.parse(localStorage.getItem('profile')) || {};
            profileData.photo = e.target.result;
            localStorage.setItem('profile', JSON.stringify(profileData));
            updateAvatarDisplay(profileData.photo);
        };
        reader.readAsDataURL(file);
    }
}

function loadProfile() {
    const profileData = JSON.parse(localStorage.getItem('profile')) || {};
    const fields = ['firstName', 'lastName', 'email', 'phone', 'dateOfBirth', 'gender', 'address'];
    
    fields.forEach(field => {
        const element = document.getElementById(field);
        if (element) element.value = profileData[field] || '';
    });

    if (profileData.photo) {
        updateAvatarDisplay(profileData.photo);
    } else {
        updateAvatarInitials();
    }
}

function updateAvatarDisplay(photoUrl) {
    const userAvatar = document.getElementById('userAvatar');
    if (photoUrl) {
        userAvatar.style.backgroundImage = `url(${photoUrl})`;
        userAvatar.textContent = '';
    } else {
        userAvatar.style.backgroundImage = '';
        updateAvatarInitials();
    }
}

function updateAvatarInitials() {
    const userAvatar = document.getElementById('userAvatar');
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    
    const firstInitial = firstName ? firstName[0].toUpperCase() : '';
    const lastInitial = lastName ? lastName[0].toUpperCase() : '';
    userAvatar.textContent = firstInitial + lastInitial;
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
        photo: JSON.parse(localStorage.getItem('profile'))?.photo || null
    };

    localStorage.setItem('profile', JSON.stringify(profileData));
    alert('Profile saved successfully!');
}

function resetProfile() {
    localStorage.removeItem('profile');
    document.getElementById('profileForm').reset();
    userAvatar.style.backgroundImage = '';
    updateAvatarInitials();
}