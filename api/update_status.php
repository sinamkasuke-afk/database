<?php
include "api/db.php";

$id = $_GET["id"] ?? "";
$status = $_GET["status"] ?? "";

if ($status === "approved") {
    $newStatus = "Approved";
} elseif ($status === "declined") {
    $newStatus = "Declined";
} else {
    die("Invalid status.");
}

$stmt = $conn->prepare("UPDATE reservations SET status = ? WHERE id = ?");
$stmt->bind_param("si", $newStatus, $id);

if ($stmt->execute()) {
    header("Location: reservation.php");
    exit;
} else {
    echo "Failed to update status.";
}
?>