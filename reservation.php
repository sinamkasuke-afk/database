<?php
include "api/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Reservation Requests</title>

  <link rel="stylesheet" href="base.css">
  <link rel="stylesheet" href="reservation.css">
</head>

<body>

<div class="layout">

  <main class="main">

    <section class="content">

      <div class="page-title-row">

        <div class="title-left">

          <div class="title-icon" data-ico="reservation"></div>

          <div>
            <h1>Reservation Requests</h1>
            <p>Manage and review all facility reservation requests.</p>
          </div>

        </div>

      </div>

      <div class="card">

        <div class="table-wrap">

          <table>

            <thead>

              <tr>
                <th>REQUEST ID</th>
                <th>REQUESTER</th>
                <th>VENUE</th>
                <th>DATE</th>
                <th>TIME</th>
                <th>STATUS</th>
                <th>ACTION</th>
              </tr>

            </thead>

            <tbody>

<?php

$sql = "SELECT * FROM reservations ORDER BY id DESC";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()):

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
<?php echo date("F j, Y", strtotime($row['reservation_date'])); ?>
</td>

<td>

<?php echo date("g:i A", strtotime($row['start_time'])); ?>

-

<?php echo date("g:i A", strtotime($row['end_time'])); ?>

</td>

<td>

<?php if(strtolower($row['status']) == 'approved'): ?>

<span class="status approved">
Approved
</span>

<?php elseif(strtolower($row['status']) == 'declined'): ?>

<span class="status declined">
Declined
</span>

<?php else: ?>

<span class="status pending">
Pending
</span>

<?php endif; ?>

</td>

<td>

<?php if(strtolower($row['status']) == 'pending'): ?>

<a class="approve-btn" href="update_status.php?id=<?php echo $row['id']; ?>&status=approved">
  Approve
</a>

<a class="decline-btn" href="update_status.php?id=<?php echo $row['id']; ?>&status=declined">
  Decline
</a>

<?php else: ?>

-

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

            </tbody>

          </table>

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
initShell("reservation");
</script>

</body>
</html>