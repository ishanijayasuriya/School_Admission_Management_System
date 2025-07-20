 <?php
header('Content-Type: application/json');
require 'db_config.php';
require 'send_email.php'; // We'll create this in Step 3

$errors = [];

// Sanitize & validate inputs
$fullName = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$role = $_POST['role'] ?? '';
$studentName = trim($_POST['student_name'] ?? '');
$studentDOB = $_POST['student_dob'] ?? '';
$systemId = $_POST['generated_id'] ?? '';

// 1. Basic validation
if (!$fullName || !$email || !$phone || !$username || !$password || !$confirmPassword || !$role || !$systemId) {
    $errors[] = "All required fields must be filled.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (!preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Phone number must be 10 digits.";
}

if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
}

// 2. Student details only for parent/student
if (in_array($role, ['parent', 'ministry_staff'])) {
    if (!$studentName || !$studentDOB) {
        $errors[] = "Student details are required for Parent or Student role.";
    }
}

// 3. Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 4. Check if username or email already exists
$checkStmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
$checkStmt->execute([$email, $username]);

if ($checkStmt->fetch()) {
    $errors[] = "Username or Email already exists.";
}

// 5. Stop if any error
if (!empty($errors)) {
    echo json_encode(["success" => false, "errors" => $errors]);
    exit();
}

// 6. Insert user into database
$insert = $pdo->prepare("
    INSERT INTO users (id, full_name, email, phone, username, password, role, student_name, student_dob)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$insert->execute([
    $systemId,
    $fullName,
    $email,
    $phone,
    $username,
    $hashedPassword,
    $role,
    $role === 'school_admin' ? null : $studentName,
    $role === 'school_admin' ? null : $studentDOB
]);

// 7. Send email
send_registration_email($email, $systemId, $username, $role);

// 8. Response back
echo json_encode([
    "success" => true,
    "data" => [
        "system_id" => $systemId,
        "username" => $username,
        "email" => $email,
        "role" => ucfirst($role)
    ]
]);
?>
