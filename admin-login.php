<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "facilities_reservation");

if (!$conn) {
    die("Connection failed");
}

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $_SESSION['admin'] = $email;
    header("Location: admin-dashboard.php");
    exit();
} else {
    echo "<script>
        alert('Invalid admin email or password!');
        window.location.href='admin-login.html';
    </script>";
    exit();
}
?>