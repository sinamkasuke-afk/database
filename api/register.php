<?php
header("Content-Type: application/json");
include "db.php";

$full_name = $_POST["full_name"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$role = "student";

if (
  $full_name == "" ||
  $email == "" ||
  $password == ""
) {
  echo json_encode([
    "success" => false,
    "message" => "Please complete all fields."
  ]);
  exit;
}

$check = $conn->prepare("
  SELECT id
  FROM users
  WHERE email = ?
");

$check->bind_param("s", $email);
$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {
  echo json_encode([
    "success" => false,
    "message" => "Email already exists."
  ]);
  exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
  INSERT INTO users (
    full_name,
    email,
    password,
    role
  )
  VALUES (?, ?, ?, ?)
");

$stmt->bind_param(
  "ssss",
  $full_name,
  $email,
  $hashedPassword,
  $role
);

if ($stmt->execute()) {

  echo json_encode([
    "success" => true,
    "message" => "Account created successfully."
  ]);

} else {

  echo json_encode([
    "success" => false,
    "message" => "Database error."
  ]);

}
?>