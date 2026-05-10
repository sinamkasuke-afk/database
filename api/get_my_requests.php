<?php
header("Content-Type: application/json");
include "db.php";

$email = $_GET["email"] ?? "";

if ($email == "") {
  echo json_encode([]);
  exit;
}

$stmt = $conn->prepare("
  SELECT *
  FROM reservations
  WHERE requester_email = ?
  ORDER BY id DESC
");

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
  $data[] = [
    "id" => "REQ-2026-" . str_pad($row["id"], 4, "0", STR_PAD_LEFT),
    "venue" => $row["venue_name"],
    "date" => date("F j, Y", strtotime($row["reservation_date"])),
    "time" => date("g:i A", strtotime($row["start_time"])) . " - " . date("g:i A", strtotime($row["end_time"])),
    "status" => strtolower($row["status"])
  ];
}

echo json_encode($data);
?>