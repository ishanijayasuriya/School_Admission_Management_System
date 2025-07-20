<?php
require_once '../db_config.php'; // DB connection

// Collect form data
$current_school = $_POST['current_school'];
$educational_zone = $_POST['educational_zone'];
$student_name = $_POST['student_name'];
$medium = $_POST['medium'];
$gender = $_POST['gender'];
$birth_year = $_POST['birth_year'];
$birth_month = $_POST['birth_month'];
$birth_day = $_POST['birth_day'];
$guardian_name = $_POST['guardian_name'];
$address = $_POST['address'];
$telephone = $_POST['telephone'];
$scholarship_marks = $_POST['scholarship_marks'];
$scholarship_index = $_POST['scholarship_index'];
$scholarship_year = $_POST['scholarship_year'];
$special_skills = $_POST['special_skills'];
$certificate_date = $_POST['certificate_date'];
$school_name_address = $_POST['school_name_address'];

// File upload
$upload_dir = '../../uploads/grade6/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

function saveFile($file, $upload_dir) {
    $filename = uniqid() . '_' . basename($file['name']);
    $target = $upload_dir . $filename;
    move_uploaded_file($file['tmp_name'], $target);
    return $filename;
}

$guardian_signature = saveFile($_FILES['guardian_signature'], $upload_dir);
$principal_certificate = saveFile($_FILES['principal_certificate'], $upload_dir);
$principal_signature = saveFile($_FILES['principal_signature'], $upload_dir);
$official_seal = saveFile($_FILES['official_seal'], $upload_dir);

try {
    $stmt = $pdo->prepare("INSERT INTO grade_6_applications (
        current_school, educational_zone, student_name, medium, gender,
        birth_year, birth_month, birth_day, guardian_name, address, telephone,
        scholarship_marks, scholarship_index, scholarship_year, special_skills,
        guardian_signature, principal_certificate, principal_signature, school_name_address,
        official_seal, certificate_date
    ) VALUES (
        :current_school, :educational_zone, :student_name, :medium, :gender,
        :birth_year, :birth_month, :birth_day, :guardian_name, :address, :telephone,
        :scholarship_marks, :scholarship_index, :scholarship_year, :special_skills,
        :guardian_signature, :principal_certificate, :principal_signature, :school_name_address,
        :official_seal, :certificate_date
    )");

    $stmt->execute([
        'current_school' => $current_school,
        'educational_zone' => $educational_zone,
        'student_name' => $student_name,
        'medium' => $medium,
        'gender' => $gender,
        'birth_year' => $birth_year,
        'birth_month' => $birth_month,
        'birth_day' => $birth_day,
        'guardian_name' => $guardian_name,
        'address' => $address,
        'telephone' => $telephone,
        'scholarship_marks' => $scholarship_marks,
        'scholarship_index' => $scholarship_index,
        'scholarship_year' => $scholarship_year,
        'special_skills' => $special_skills,
        'guardian_signature' => $guardian_signature,
        'principal_certificate' => $principal_certificate,
        'principal_signature' => $principal_signature,
        'school_name_address' => $school_name_address,
        'official_seal' => $official_seal,
        'certificate_date' => $certificate_date
    ]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
