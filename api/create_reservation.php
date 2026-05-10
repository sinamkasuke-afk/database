<?php
header("Content-Type: application/json");
include "db.php";

$venue_name = $_POST["venue_name"] ?? "";
$event_name = $_POST["event_name"] ?? "";
$organization = $_POST["organization"] ?? "";
$event_type = $_POST["event_type"] ?? "";
$expected_guests = $_POST["expected_guests"] ?? 0;
$purpose = $_POST["purpose"] ?? "";
$contact_person = $_POST["contact_person"] ?? "";
$contact_email = $_POST["contact_email"] ?? "";
$contact_number = $_POST["contact_number"] ?? "";
$reservation_date = $_POST["reservation_date"] ?? "";
$start_time = $_POST["start_time"] ?? "";
$end_time = $_POST["end_time"] ?? "";
$facility_requirements = $_POST["facility_requirements"] ?? "";
$setup_notes = $_POST["setup_notes"] ?? "";
$supporting_document = $_POST["supporting_document"] ?? "";

$facility_id = 1;
$status = "Pending";

if ($venue_name == "" || $event_name == "" || $contact_person == "" || $contact_email == "") {
    echo json_encode([
        "success" => false,
        "message" => "Missing required reservation information."
    ]);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO reservations (
        facility_id,
        venue_name,
        requester_name,
        requester_email,
        event_name,
        organization,
        event_type,
        expected_guests,
        reservation_date,
        start_time,
        end_time,
        purpose,
        contact_number,
        facility_requirements,
        setup_notes,
        supporting_document,
        status
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issssssisssssssss",
    $facility_id,
    $venue_name,
    $contact_person,
    $contact_email,
    $event_name,
    $organization,
    $event_type,
    $expected_guests,
    $reservation_date,
    $start_time,
    $end_time,
    $purpose,
    $contact_number,
    $facility_requirements,
    $setup_notes,
    $supporting_document,
    $status
);

if ($stmt->execute()) {

    $reservationId = $conn->insert_id;

    echo json_encode([
        "success" => true,
        "reservation_id" => $reservationId,
        "message" => "Reservation saved successfully."
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $stmt->error
    ]);

}
?>