<?php

header("Content-Type: application/json");

include "db.php";

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$role = $_POST["role"] ?? "";

if ($email == "" || $password == "" || $role == "") {

    echo json_encode([
        "success" => false,
        "message" => "Please complete all fields."
    ]);

    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM users
    WHERE email = ?
    AND role = ?
    LIMIT 1
");

$stmt->bind_param("ss", $email, $role);

$stmt->execute();

$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {

    if ($password != $user["password"]) {

        echo json_encode([
            "success" => false,
            "message" => "Incorrect password."
        ]);

        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Login successful.",
        "user" => [
            "id" => $user["id"],
            "full_name" => $user["full_name"],
            "email" => $user["email"],
            "role" => $user["role"]
        ]
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Account not found."
    ]);

}

?>