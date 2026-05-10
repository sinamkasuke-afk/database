<?php
include "api/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>History</title>

  <link rel="stylesheet" href="base.css" />
  <link rel="stylesheet" href="history.css" />
</head>

<body>

<div class="layout">

  <main class="main">

    <section class="content">

      <div class="page-title-row">

        <div class="title-left">

          <div class="title-icon" data-ico="history"></div>

          <div>
            <h1>History</h1>
            <p>Review approved and declined reservation records.</p>
          </div>

        </div>

        <input
          id="search"
          class="search"
          placeholder="Search history..."
        />

      </div>

      <p class="history-note">
        This page automatically updates after approving or declining requests.
      </p>

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
                <th>FINAL STATUS</th>
              </tr>
            </thead>

            <tbody id="rows">

            <?php

            $sql = "SELECT * FROM reservations
                    WHERE LOWER(TRIM(status)) = 'approved'
                    OR LOWER(TRIM(status)) = 'declined'
                    ORDER BY id DESC";

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
                <span class="subtext">Requester</span>
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

                <?php if($status == 'approved'): ?>

                  <span class="status approved">
                    Approved
                  </span>

                <?php elseif($status == 'declined'): ?>

                  <span class="status declined">
                    Declined
                  </span>

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
      © 2026 National University Manila<br />
      Physical Facilities Management Office
    </footer>

  </main>

</div>

<script src="app.js"></script>

<script>
initShell("history");

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