<?php
require_once '../../db_config.php';

function uploadFile($file, $targetDir) {
    if ($file && $file['error'] === 0) {
        $filename = uniqid() . '_' . basename($file['name']);
        $destination = $targetDir . $filename;
        move_uploaded_file($file['tmp_name'], $destination);
        return $filename;
    }
    return null;
}

$uploadDir = '../../uploads/grade12/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

// Collect inputs
$fields = [
    'fullName', 'nameWithInitials', 'permanentAddress', 'telephone', 'gender', 'teachingMedium',
    'guardianAddress', 'birthYear', 'birthMonth', 'birthDate', 'ageYear', 'ageMonth', 'ageDate',
    'nic', 'olSchoolName', 'olSchoolAddress', 'admissionNo', 'schoolDistrict', 'achievements',
    'ol1Year', 'ol1ExamNo', 'ol2Year', 'ol2ExamNo',
    'sinhalaGrade', 'sinhalaSkill', 'sinhalaGrade2',
    'tamilGrade', 'tamilSkill', 'tamilGrade2',
    'englishGrade', 'englishSkill', 'englishGrade2',
    'mathsGrade', 'mathsSkill', 'mathsGrade2',
    'scienceGrade', 'scienceSkill', 'scienceGrade2',
    'subject6', 'subject6Grade', 'subject6Skill', 'subject6Grade2',
    'subject7', 'subject7Grade', 'subject7Skill', 'subject7Grade2',
    'subject8', 'subject8Grade', 'subject8Skill', 'subject8Grade2',
    'subject9', 'subject9Grade', 'subject9Skill', 'subject9Grade2',
    'subject10', 'subject10Grade', 'subject10Skill', 'subject10Grade2',
    'Subject1', 'Subject2', 'Subject3', 'Subject4',
    'medium1', 'medium2', 'medium3', 'medium4',
    'school1', 'address1', 'school2', 'address2', 'school3', 'address3', 'school4', 'address4',
    'currentSchool', 'currentGrade', 'notes', 'date'
];

$data = [];
foreach ($fields as $field) {
    $data[$field] = $_POST[$field] ?? '';
}

// File uploads
$photoUpload = uploadFile($_FILES['photoUpload'], $uploadDir);
$principalSignature = uploadFile($_FILES['signatureImage'], $uploadDir);
$studentSignature = uploadFile($_FILES['studentSignature'], $uploadDir);
$guardianSignature = uploadFile($_FILES['guardianSignature'], $uploadDir);

// Prepare SQL
$sql = "INSERT INTO grade_12_applications (
    full_name, name_with_initials, permanent_address, telephone, gender, teaching_medium,
    guardian_address, birth_year, birth_month, birth_date, age_year, age_month, age_date,
    nic, ol_school_name, ol_school_address, admission_no, school_district, achievements,
    ol1_year, ol1_exam_no, ol2_year, ol2_exam_no,
    sinhala_grade, sinhala_skill, sinhala_grade2,
    tamil_grade, tamil_skill, tamil_grade2,
    english_grade, english_skill, english_grade2,
    maths_grade, maths_skill, maths_grade2,
    science_grade, science_skill, science_grade2,
    subject6, subject6_grade, subject6_skill, subject6_grade2,
    subject7, subject7_grade, subject7_skill, subject7_grade2,
    subject8, subject8_grade, subject8_skill, subject8_grade2,
    subject9, subject9_grade, subject9_skill, subject9_grade2,
    subject10, subject10_grade, subject10_skill, subject10_grade2,
    subject1, subject2, subject3, subject4,
    medium1, medium2, medium3, medium4,
    school1, address1, school2, address2, school3, address3, school4, address4,
    current_school, current_grade, notes, submission_date,
    photo_upload, principal_signature, student_signature, guardian_signature
) VALUES (
    :fullName, :nameWithInitials, :permanentAddress, :telephone, :gender, :teachingMedium,
    :guardianAddress, :birthYear, :birthMonth, :birthDate, :ageYear, :ageMonth, :ageDate,
    :nic, :olSchoolName, :olSchoolAddress, :admissionNo, :schoolDistrict, :achievements,
    :ol1Year, :ol1ExamNo, :ol2Year, :ol2ExamNo,
    :sinhalaGrade, :sinhalaSkill, :sinhalaGrade2,
    :tamilGrade, :tamilSkill, :tamilGrade2,
    :englishGrade, :englishSkill, :englishGrade2,
    :mathsGrade, :mathsSkill, :mathsGrade2,
    :scienceGrade, :scienceSkill, :scienceGrade2,
    :subject6, :subject6Grade, :subject6Skill, :subject6Grade2,
    :subject7, :subject7Grade, :subject7Skill, :subject7Grade2,
    :subject8, :subject8Grade, :subject8Skill, :subject8Grade2,
    :subject9, :subject9Grade, :subject9Skill, :subject9Grade2,
    :subject10, :subject10Grade, :subject10Skill, :subject10Grade2,
    :Subject1, :Subject2, :Subject3, :Subject4,
    :medium1, :medium2, :medium3, :medium4,
    :school1, :address1, :school2, :address2, :school3, :address3, :school4, :address4,
    :currentSchool, :currentGrade, :notes, :date,
    :photoUpload, :principalSignature, :studentSignature, :guardianSignature
)";

$stmt = $pdo->prepare($sql);
$data['photoUpload'] = $photoUpload;
$data['principalSignature'] = $principalSignature;
$data['studentSignature'] = $studentSignature;
$data['guardianSignature'] = $guardianSignature;

try {
    $stmt->execute($data);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
