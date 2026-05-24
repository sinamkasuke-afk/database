<?php
header("Content-Type: application/json");
include "db.php";

$reservation_date = $_GET["reservation_date"] ?? "";

$allSlots = [
  "7:00 AM – 10:00 AM",
  "10:00 AM – 1:00 PM",
  "1:00 PM – 4:00 PM",
  "4:00 PM – 7:00 PM",
  "7:00 PM – 10:00 PM"
];

$response = [];

foreach ($allSlots as $slot) {

  $status = "Available";

  if ($slot == "7:00 AM – 10:00 AM") {
    $start = "07:00:00";
    $end = "10:00:00";
  }

  if ($slot == "10:00 AM – 1:00 PM") {
    $start = "10:00:00";
    $end = "13:00:00";
  }

  if ($slot == "1:00 PM – 4:00 PM") {
    $start = "13:00:00";
    $end = "16:00:00";
  }

  if ($slot == "4:00 PM – 7:00 PM") {
    $start = "16:00:00";
    $end = "19:00:00";
  }

  if ($slot == "7:00 PM – 10:00 PM") {
    $start = "19:00:00";
    $end = "22:00:00";
  }

  $stmt = $conn->prepare("
    SELECT status
    FROM reservations
    WHERE reservation_date = ?
    AND start_time = ?
    AND end_time = ?
    LIMIT 1
  ");

  $stmt->bind_param(
    "sss",
    $reservation_date,
    $start,
    $end
  );

  $stmt->execute();

  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $status = $row["status"];
  }

  $response[] = [
    "time" => $slot,
    "status" => $status
  ];
}

echo json_encode($response);
?>