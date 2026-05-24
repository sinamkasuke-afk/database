<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.html");
    exit();
}
?>
<?php
include "api/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dashboard</title>

  <link rel="stylesheet" href="base.css">
  <link rel="stylesheet" href="dashboard.css">
</head>

<body>

<div class="layout">

  <main class="main">

    <section class="content">

      <div class="page-title-row">

        <div class="title-left">

          <div class="title-icon" data-ico="dashboard"></div>

          <div>
            <h1>Dashboard</h1>
            <p>Overview of all facility reservation requests.</p>
          </div>

        </div>

        <input
          id="search"
          class="search"
          placeholder="Search request ID, requester, or status..."
        />

      </div>

<?php

$total =
$conn->query("SELECT COUNT(*) as total FROM reservations")
->fetch_assoc()['total'];

$pending =
$conn->query("SELECT COUNT(*) as total FROM reservations WHERE LOWER(TRIM(status))='pending'")
->fetch_assoc()['total'];

$approved =
$conn->query("SELECT COUNT(*) as total FROM reservations WHERE LOWER(TRIM(status))='approved'")
->fetch_assoc()['total'];

$declined =
$conn->query("SELECT COUNT(*) as total FROM reservations WHERE LOWER(TRIM(status))='declined'")
->fetch_assoc()['total'];

?>

      <div class="stats">

        <div class="stat-card">
          <p>Total Requests</p>
          <h2><?php echo $total; ?></h2>
        </div>

        <div class="stat-card">
          <p>Pending</p>
          <h2><?php echo $pending; ?></h2>
        </div>

        <div class="stat-card">
          <p>Approved</p>
          <h2><?php echo $approved; ?></h2>
        </div>

        <div class="stat-card">
          <p>Declined</p>
          <h2><?php echo $declined; ?></h2>
        </div>

      </div>

      <div class="dashboard-grid">

        <div class="card">

          <h3 class="mini-title">
            Recent Reservation Requests
          </h3>

          <div class="table-wrap">

            <table>

              <thead>
                <tr>
                  <th>REQUEST ID</th>
                  <th>REQUESTER</th>
                  <th>VENUE</th>
                  <th>STATUS</th>
                </tr>
              </thead>

              <tbody id="rows">

<?php

$sql = "SELECT * FROM reservations ORDER BY id DESC LIMIT 7";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()):

$status = strtolower(trim($row['status']));

?>

<tr>

<td>
REQ-2026-<?php echo str_pad($row['id'], 4, "0", STR_PAD_LEFT); ?>
</td>

<td>
<b><?php echo $row['requester_name']; ?></b><br>

<span class="subtext">
<?php echo $row['requester_email']; ?>
</span>
</td>

<td>
<?php echo $row['venue_name']; ?>
</td>

<td>

<?php if($status == 'approved'): ?>

<span class="status approved">
Approved
</span>

<?php elseif($status == 'declined'): ?>

<span class="status declined">
Declined
</span>

<?php else: ?>

<span class="status pending">
Pending
</span>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

              </tbody>

            </table>

          </div>

        </div>

        <div class="card">

          <h3 class="mini-title">
            Status Summary
          </h3>

          <div class="status-list">

            <div>
              <span>Pending</span>
              <span><?php echo $pending; ?></span>
            </div>

            <div>
              <span>Approved</span>
              <span><?php echo $approved; ?></span>
            </div>

            <div>
              <span>Declined</span>
              <span><?php echo $declined; ?></span>
            </div>

          </div>

        </div>

      </div>

    </section>

    <footer class="footer">
      © 2026 National University Manila<br>
      Physical Facilities Management Office
    </footer>

  </main>

</div>

<script src="app.js"></script>

<script>
initShell("dashboard");

const search = document.getElementById("search");

search.addEventListener("keyup", function () {
  let value = this.value.toLowerCase();
  let rows = document.querySelectorAll("#rows tr");

  rows.forEach(row => {
    row.style.display =
      row.innerText.toLowerCase().includes(value)
        ? ""
        : "none";
  });
});
</script>

</body>
</html>