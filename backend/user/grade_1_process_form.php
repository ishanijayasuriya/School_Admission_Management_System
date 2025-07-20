<?php
require_once '../db_config.php'; // Update path as needed

function uploadFile($file, $targetDir) {
    if ($file && $file['error'] === 0) {
        $filename = uniqid() . '_' . basename($file['name']);
        $destination = $targetDir . $filename;
        move_uploaded_file($file['tmp_name'], $destination);
        return $filename;
    }
    return null;
}

$uploadDir = '../../uploads/grade1/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

// Basic fields
$categories = isset($_POST['categories']) ? implode(', ', $_POST['categories']) : '';
$full_name = $_POST['fullName'];
$name_sinhala = $_POST['nameSinhala'];
$name_english = $_POST['nameEnglish'];
$gender = $_POST['gender'];
$religion = $_POST['religion'];
$medium = $_POST['medium'];
$dob = $_POST['dob'];
$age_years = $_POST['ageYears'];
$age_months = $_POST['ageMonths'];
$age_days = $_POST['ageDays'];

$applicant_full_name = $_POST['applicantFullName'];
$applicant_initials = $_POST['applicantInitials'];
$applicant_nic = $_POST['applicantNIC'];
$applicant_sri_lankan = $_POST['applicantSriLankan'];
$applicant_religion = $_POST['applicantReligion'];
$applicant_address = $_POST['applicantAddress'];
$applicant_phone = $_POST['applicantPhone'];
$applicant_district = $_POST['applicantDistrict'];
$applicant_ds_division = $_POST['applicantDSDivision'];
$applicant_gn_domain = $_POST['applicantGNDomain'];
$applicant_gn_number = $_POST['applicantGNNumber'];

$partner_full_name = $_POST['partnerFullName'];
$partner_initials = $_POST['partnerInitials'];
$partner_nic = $_POST['partnerNIC'];
$partner_sri_lankan = $_POST['partnerSriLankan'];
$partner_religion = $_POST['partnerReligion'];
$partner_address = $_POST['partnerAddress'];
$partner_phone = $_POST['partnerPhone'];
$partner_district = $_POST['partnerDistrict'];
$partner_ds_division = $_POST['partnerDSDivision'];
$partner_gn_domain = $_POST['partnerGNDomain'];
$partner_gn_number = $_POST['partnerGNNumber'];

// JSON Fields
$schools = json_encode($_POST['schools']);
$other_schools = json_encode($_POST['otherSchools']);
$guardianship = json_encode([
    'year' => $_POST['guardianshipYear'],
    'constituency' => $_POST['guardianshipConstituency'],
    'division' => $_POST['guardianshipDivision'],
    'village' => $_POST['guardianshipVillage'],
    'gn' => $_POST['guardianshipGNDivision'],
    'house_no' => $_POST['guardianshipHouseNo'],
    'order_no' => $_POST['guardianshipOrderNo'],
    'voters' => $_POST['guardianshipVoters'],
]);

$category_data = json_encode([
    'section7_1' => $_POST['applicantElectoralYears'] ?? null,
    'section7_2' => $_POST['alumniGradesStudied'] ?? null,
    'section7_3' => $_POST['siblingName'] ?? null,
    'section7_4' => $_POST['staffFirstAppointmentPlace'] ?? null,
    'section7_5' => $_POST['transferLastTransferDate'] ?? null,
    'section7_6' => $_POST['abroadReturnDate'] ?? null
]);

$declaration_date = $_POST['signatureDate'] ?? null;

// File uploads
$signature_image = uploadFile($_FILES['signatureImage'], $uploadDir);
$birth_certificate = uploadFile($_FILES['signatureImage'], $uploadDir);
$parent_birth_certificates = uploadFile($_FILES['signatureImage'], $uploadDir);
$affidavit = uploadFile($_FILES['signatureImage'], $uploadDir);

try {
    $stmt = $pdo->prepare("INSERT INTO grade_1_applications (
        categories, full_name, name_sinhala, name_english, gender, religion, medium, dob, 
        age_years, age_months, age_days, applicant_full_name, applicant_initials, applicant_nic, 
        applicant_sri_lankan, applicant_religion, applicant_address, applicant_phone, 
        applicant_district, applicant_ds_division, applicant_gn_domain, applicant_gn_number,
        partner_full_name, partner_initials, partner_nic, partner_sri_lankan, partner_religion, 
        partner_address, partner_phone, partner_district, partner_ds_division, partner_gn_domain, 
        partner_gn_number, schools, other_schools, guardianship, category_data, declaration_date, 
        signature_image, birth_certificate, parent_birth_certificates, affidavit
    ) VALUES (
        :categories, :full_name, :name_sinhala, :name_english, :gender, :religion, :medium, :dob, 
        :age_years, :age_months, :age_days, :applicant_full_name, :applicant_initials, :applicant_nic, 
        :applicant_sri_lankan, :applicant_religion, :applicant_address, :applicant_phone, 
        :applicant_district, :applicant_ds_division, :applicant_gn_domain, :applicant_gn_number,
        :partner_full_name, :partner_initials, :partner_nic, :partner_sri_lankan, :partner_religion, 
        :partner_address, :partner_phone, :partner_district, :partner_ds_division, :partner_gn_domain, 
        :partner_gn_number, :schools, :other_schools, :guardianship, :category_data, :declaration_date, 
        :signature_image, :birth_certificate, :parent_birth_certificates, :affidavit
    )");

    $stmt->execute([
        'categories' => $categories,
        'full_name' => $full_name,
        'name_sinhala' => $name_sinhala,
        'name_english' => $name_english,
        'gender' => $gender,
        'religion' => $religion,
        'medium' => $medium,
        'dob' => $dob,
        'age_years' => $age_years,
        'age_months' => $age_months,
        'age_days' => $age_days,
        'applicant_full_name' => $applicant_full_name,
        'applicant_initials' => $applicant_initials,
        'applicant_nic' => $applicant_nic,
        'applicant_sri_lankan' => $applicant_sri_lankan,
        'applicant_religion' => $applicant_religion,
        'applicant_address' => $applicant_address,
        'applicant_phone' => $applicant_phone,
        'applicant_district' => $applicant_district,
        'applicant_ds_division' => $applicant_ds_division,
        'applicant_gn_domain' => $applicant_gn_domain,
        'applicant_gn_number' => $applicant_gn_number,
        'partner_full_name' => $partner_full_name,
        'partner_initials' => $partner_initials,
        'partner_nic' => $partner_nic,
        'partner_sri_lankan' => $partner_sri_lankan,
        'partner_religion' => $partner_religion,
        'partner_address' => $partner_address,
        'partner_phone' => $partner_phone,
        'partner_district' => $partner_district,
        'partner_ds_division' => $partner_ds_division,
        'partner_gn_domain' => $partner_gn_domain,
        'partner_gn_number' => $partner_gn_number,
        'schools' => $schools,
        'other_schools' => $other_schools,
        'guardianship' => $guardianship,
        'category_data' => $category_data,
        'declaration_date' => $declaration_date,
        'signature_image' => $signature_image,
        'birth_certificate' => $birth_certificate,
        'parent_birth_certificates' => $parent_birth_certificates,
        'affidavit' => $affidavit
    ]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
//  Final step after inserting to database
    echo "<script>
        alert('Application submitted successfully!');
    window.location.href='../../Front-end/user/dashboard.html';
</script>";
exit();

?>
