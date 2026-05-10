<?php
include "api/db.php";

$result = $conn->query("
    SELECT * FROM reservations
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Reservation Requests</title>
</head>
<body>

<h1>Reservation Requests</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Venue</th>
        <th>Requester</th>
        <th>Email</th>
        <th>Event</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["venue_name"]; ?></td>
        <td><?php echo $row["requester_name"]; ?></td>
        <td><?php echo $row["requester_email"]; ?></td>
        <td><?php echo $row["event_name"]; ?></td>
        <td><?php echo $row["reservation_date"]; ?></td>
        <td><?php echo $row["start_time"] . " - " . $row["end_time"]; ?></td>
        <td><?php echo $row["status"]; ?></td>

        <td>
            <?php if($row["status"] == "pending"): ?>

                <a href="update_status.php?id=<?php echo $row["id"]; ?>&status=approved">
                    Approve
                </a>

                |

                <a href="update_status.php?id=<?php echo $row["id"]; ?>&status=declined">
                    Decline
                </a>

            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>