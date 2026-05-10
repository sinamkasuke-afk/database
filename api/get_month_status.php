<?php
header("Content-Type: application/json");
include "db.php";

$year = $_GET["year"] ?? "";
$month = $_GET["month"] ?? "";

$stmt = $conn->prepare("
  SELECT reservation_date, status
  FROM reservations
  WHERE YEAR(reservation_date) = ?
  AND MONTH(reservation_date) = ?
");

$stmt->bind_param("ii", $year, $month);

$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {

  $data[] = [
    "date" => $row["reservation_date"],
    "status" => $row["status"]
  ];

}

echo json_encode($data);
?>