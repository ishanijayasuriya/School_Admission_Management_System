 <?php
$password = 'Parent@123'; // Replace with the password you want to hash
$hashed = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashed;

echo password_hash("Parent@123", PASSWORD_DEFAULT);


