<?php
require_once '../../backend/db_config.php';
require_once '../../backend/send_email.php';

// Fetch all Grade 6 applications
$stmt = $pdo->query("SELECT * FROM grade_6_applications ORDER BY submitted_at DESC");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Grade 6 Application Verification</title>
  <link rel="stylesheet" href="../../Front-end/admin/css/style.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    .modal {
      display: none; position: fixed; top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6); z-index: 999;
    }
    .modal-content {
      background: white; margin: 10% auto; padding: 20px;
      width: 60%; border-radius: 10px;
    }
    .close {
      float: right; font-size: 24px; cursor: pointer;
    }
  </style>
</head>
<body>
<div class="admin-container">
  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="logo"><span>Admin Panel</span></div>
    <ul>
      <li><a href="../../Front-end/admin/dashboard.html"><i class="fas fa-file-alt"></i> Dashboard</a></li>
      <li class="active"><a href="grade6_application_view.php"><i class="fas fa-tachometer-alt"></i> Grade 6 Applications</a></li>
      <li><a href="../../Front-end/admin/u_accounts_management.html"><i class="fas fa-users"></i> User Management</a></li>
    </ul>
    <div class="sidebar-footer">
      <a href="../../backend/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <header class="top-bar"><h1>Grade 6 Document Verification</h1></header>

    <div class="documents-grid">
      <?php foreach ($applications as $app): ?>
        <div class="document-card <?= $app['status'] ?>">
          <div class="document-preview">
            <img src="../../uploads/<?= htmlspecialchars($app['birth_certificate']) ?>" alt="Document">
          </div>
          <div class="document-info">
            <h3>Birth Certificate</h3>
            <p><strong>Application:</strong> <?= htmlspecialchars($app['id']) ?></p>
            <p><strong>Student:</strong> <?= htmlspecialchars($app['full_name']) ?></p>
            <p><strong>Submitted:</strong> <?= htmlspecialchars($app['submitted_at']) ?></p>
            <div class="document-status <?= $app['status'] ?>">
              <i class="fas fa-clock"></i> <?= ucfirst($app['status']) ?>
            </div>
            <button class="btn btn-view"
              onclick='openApplicationModal(<?= json_encode($app, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>)'>
              <i class="fas fa-eye"></i> View Application
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Modal -->
    <div class="modal" id="applicationModal">
      <div class="modal-content">
        <span class="close" onclick="closeApplicationModal()">&times;</span>
        <h2>Application Details</h2>
        <div id="modalBody"></div>
      </div>
    </div>
  </main>
</div>

<!-- JavaScript -->
<script>
function openApplicationModal(app) {
  const modal = document.getElementById('applicationModal');
  const body = document.getElementById('modalBody');

  body.innerHTML = `
    <p><strong>Application ID:</strong> ${app.id}</p>
    <p><strong>Full Name:</strong> ${app.full_name}</p>
    <p><strong>Date of Birth:</strong> ${app.dob || 'Not provided'}</p>
    <p><strong>Parent Name:</strong> ${app.applicant_full_name || 'Not provided'}</p>
    <p><strong>Email:</strong> ${app.applicant_email || 'N/A'}</p>
    <p><strong>Birth Certificate:</strong> <a href='../../uploads/${app.birth_certificate}' target='_blank'>View</a></p>
    <p><strong>Status:</strong> ${app.status}</p>
    <form method="post" action="../../backend/admin/update_document_status.php">
      <input type="hidden" name="id" value="${app.id}">
      <input type="hidden" name="email" value="${app.applicant_email}">
      <input type="hidden" name="full_name" value="${app.full_name}">
      <textarea name="notes" rows="3" placeholder="Verification notes (optional)" style="width:100%; margin:10px 0;"></textarea>
      <button type="submit" name="status" value="verified" class="btn btn-success">✅ Verify</button>
      <button type="submit" name="status" value="rejected" class="btn btn-danger">❌ Reject</button>
    </form>
  `;

  modal.style.display = 'block';
}

function closeApplicationModal() {
  document.getElementById('applicationModal').style.display = 'none';
}
</script>
</body>
</html>
