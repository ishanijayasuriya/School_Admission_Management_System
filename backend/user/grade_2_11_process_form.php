<?php
// backend/user/grade_2_11_process_form.php

require_once '../../db_config.php'; // Adjust path as needed
require_once '../../backend/send_email.php';

if (!empty($_POST['applicantEmail'])) {
    $to = $_POST['applicantEmail'];
    $subject = "Your Grade 2–11 School Admission Application";
    $message = "Dear " . $_POST['applicantFullName'] . ",<br><br>Your application has been received.<br>Thank you for applying.";

    sendEmail($to, $subject, $message);
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Basic student & applicant info
        $stmt = $pdo->prepare("
            INSERT INTO grade_2_11_applications (
                applied_office, year,
                full_name, name_sinhala_tamil, name_english, gender, language,
                birth_year, birth_month, birth_day,
                age_year_input, age_years, age_months, age_days, current_school,
                applicant_full_name, applicant_initials, applicant_nic, is_sri_lankan, applicant_religion,
                applicant_address, applicant_phone, applicant_district,
                applicant_ds_division, applicant_edu_division, applicant_current_address, applicant_previous_address,
                selected_category, distance_4_1_1, reason_4_1_2, spouse_education_4_2_1, new_service_area_4_5_2,
                previous_service_area_4_5_3, service_period_from_4_5_4, service_period_to_4_5_4,
                service_years_4_5_5, service_months_4_5_5, service_days_4_5_5, distance_4_5_6,
                political_name_mentioned_4_6_1, contract_political_number_4_6_2, contract_political_nationality_4_6_3,
                distance_4_6_4, scholarship_year_4_7_1, scholarship_district_4_7_2, scholarship_marks_4_7_3,
                distance_4_7_4, nationality_4_8_1, service_area_name_4_8_1, service_period_4_8_2,
                field_service_period_4_8_3, distance_4_8_4, scholarship_year_4_9_a, scholarship_marks_4_9_a,
                last_term_marks_4_9_b, last_term_avg_4_9_b, declaration_date, guardian_signature
            ) VALUES (
                :applied_office, :year,
                :full_name, :name_sinhala_tamil, :name_english, :gender, :language,
                :birth_year, :birth_month, :birth_day,
                :age_year_input, :age_years, :age_months, :age_days, :current_school,
                :applicant_full_name, :applicant_initials, :applicant_nic, :is_sri_lankan, :applicant_religion,
                :applicant_address, :applicant_phone, :applicant_district,
                :applicant_ds_division, :applicant_edu_division, :applicant_current_address, :applicant_previous_address,
                :selected_category, :distance_4_1_1, :reason_4_1_2, :spouse_education_4_2_1, :new_service_area_4_5_2,
                :previous_service_area_4_5_3, :service_period_from_4_5_4, :service_period_to_4_5_4,
                :service_years_4_5_5, :service_months_4_5_5, :service_days_4_5_5, :distance_4_5_6,
                :political_name_mentioned_4_6_1, :contract_political_number_4_6_2, :contract_political_nationality_4_6_3,
                :distance_4_6_4, :scholarship_year_4_7_1, :scholarship_district_4_7_2, :scholarship_marks_4_7_3,
                :distance_4_7_4, :nationality_4_8_1, :service_area_name_4_8_1, :service_period_4_8_2,
                :field_service_period_4_8_3, :distance_4_8_4, :scholarship_year_4_9_a, :scholarship_marks_4_9_a,
                :last_term_marks_4_9_b, :last_term_avg_4_9_b, :declaration_date, :guardian_signature
            )
        ");

        // Bind values from $_POST
        $stmt->execute([
            ':applied_office' => $_POST['applied_office'],
            ':year' => $_POST['year'],
            ':full_name' => $_POST['fullName'],
            ':name_sinhala_tamil' => $_POST['nameSinhalaTamil'],
            ':name_english' => $_POST['nameEnglish'],
            ':gender' => $_POST['gender'],
            ':language' => $_POST['language'],
            ':birth_year' => $_POST['birthYear'],
            ':birth_month' => $_POST['birthMonth'],
            ':birth_day' => $_POST['birthDay'],
            ':age_year_input' => $_POST['ageYear'],
            ':age_years' => $_POST['ageYears'],
            ':age_months' => $_POST['ageMonths'],
            ':age_days' => $_POST['ageDays'],
            ':current_school' => $_POST['currentSchool'],

            ':applicant_full_name' => $_POST['applicantFullName'],
            ':applicant_initials' => $_POST['applicantInitials'],
            ':applicant_nic' => $_POST['applicantNIC'],
            ':is_sri_lankan' => $_POST['isSriLankan'],
            ':applicant_religion' => $_POST['applicantReligion'],
            ':applicant_address' => $_POST['applicantAddress'],
            ':applicant_phone' => $_POST['applicantPhone'],
            ':applicant_district' => $_POST['applicantDistrict'],
            ':applicant_ds_division' => $_POST['applicantDSDivision'],
            ':applicant_edu_division' => $_POST['applicantEducationDivision'],
            ':applicant_current_address' => $_POST['applicantCurrentAddress'],
            ':applicant_previous_address' => $_POST['applicantPreviousAddress'],

            ':selected_category' => $_POST['categorySelector'] ?? '',
            ':distance_4_1_1' => $_POST['distance4_1_1'] ?? null,
            ':reason_4_1_2' => $_POST['reason4_1_2'] ?? null,
            ':spouse_education_4_2_1' => $_POST['spouseEducation4_2_1'] ?? null,
            ':new_service_area_4_5_2' => $_POST['newServiceArea4_5_2'] ?? null,
            ':previous_service_area_4_5_3' => $_POST['previousServiceArea4_5_3'] ?? null,
            ':service_period_from_4_5_4' => $_POST['servicePeriodFrom4_5_4'] ?? null,
            ':service_period_to_4_5_4' => $_POST['servicePeriodTo4_5_4'] ?? null,
            ':service_years_4_5_5' => $_POST['serviceYears4_5_5'] ?? null,
            ':service_months_4_5_5' => $_POST['serviceMonths4_5_5'] ?? null,
            ':service_days_4_5_5' => $_POST['serviceDays4_5_5'] ?? null,
            ':distance_4_5_6' => $_POST['distance4_5_6'] ?? null,
            ':political_name_mentioned_4_6_1' => $_POST['politicalNameMentioned4_6_1'] ?? null,
            ':contract_political_number_4_6_2' => $_POST['contractPoliticalNumber4_6_2'] ?? null,
            ':contract_political_nationality_4_6_3' => $_POST['contractPoliticalNationality4_6_3'] ?? null,
            ':distance_4_6_4' => $_POST['distance4_6_4'] ?? null,
            ':scholarship_year_4_7_1' => $_POST['scholarshipYear4_7_1'] ?? null,
            ':scholarship_district_4_7_2' => $_POST['scholarshipDistrict4_7_2'] ?? null,
            ':scholarship_marks_4_7_3' => $_POST['scholarshipMarks4_7_3'] ?? null,
            ':distance_4_7_4' => $_POST['distance4_7_4'] ?? null,
            ':nationality_4_8_1' => $_POST['nationality4_8_1'] ?? null,
            ':service_area_name_4_8_1' => $_POST['serviceAreaName4_8_1'] ?? null,
            ':service_period_4_8_2' => $_POST['servicePeriod4_8_2'] ?? null,
            ':field_service_period_4_8_3' => $_POST['fieldServicePeriod4_8_3'] ?? null,
            ':distance_4_8_4' => $_POST['distance4_8_4'] ?? null,
            ':scholarship_year_4_9_a' => $_POST['scholarshipYear4_9_a'] ?? null,
            ':scholarship_marks_4_9_a' => $_POST['scholarshipMarks4_9_a'] ?? null,
            ':last_term_marks_4_9_b' => $_POST['lastTermMarks4_9_b'] ?? null,
            ':last_term_avg_4_9_b' => $_POST['lastTermAverage4_9_b'] ?? null,
            ':declaration_date' => $_POST['declarationDate'],
            ':guardian_signature' => $_FILES['guardianSignature']['name'] ?? null
        ]);

        echo "Application submitted successfully!";
    } else {
        echo "Invalid request method!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
