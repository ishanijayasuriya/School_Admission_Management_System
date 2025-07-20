<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'parent') {
    header("Location: ../../Front-end/user/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Admission - Gloveman School Admission System</title>
    <link rel="stylesheet" href="../../Front-end/css/u-style.css">
</head>
<body>
    <section class="hero">
        <div class="hero-content">
            <h2>Online Admission Portal</h2>
            <p>Welcome to Government School's online admission portal. Apply for admission, check your application status, and learn about our admission process for all grades.</p>
        </div>
    </section>

    <section class="services">
        <h2>Admission Services</h2>
        <p>Apply for admission to different grades at Gloveman School</p>
        
        <div class="service-cards">
            <a href="grade_1_application.php" class="service-card">
                <div class="service-icon">📄</div>
                <div class="service-title">Grade 1<br>Admission</div>
            </a>

            <a href="grade_2_to_11_application.php" class="service-card">
                <div class="service-icon">📄</div>
                <div class="service-title">Grades 2 to 11<br>Admission</div>
            </a>

            <a href="grade_6_application.php" class="service-card">
                <div class="service-icon">📄</div>
                <div class="service-title">Grade 6<br>Admission</div>
            </a>

            <a href="grade_12_application.php" class="service-card">
                <div class="service-icon">📄</div>
                <div class="service-title">Grade 12<br>Admission</div>
            </a>
        </div>
    </section>

    <script src="../../Front-end/js/apply.js"></script>
</body>
</html>
