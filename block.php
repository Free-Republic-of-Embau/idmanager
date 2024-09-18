<?php
require_once 'config.php';

$id = $_POST['id'];

// Validate input
if (!is_numeric($id) || $id < 1) {
    die("Invalid ID");
}

$conn = new mysqli($dathost, $datusr, $datpass, $datname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE govcitizen SET blocked = 1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Citizen with ID $id has been blocked.";
} else {
    echo "Error blocking citizen with ID $id.";
}

$conn->close();

header("Location: profile.php?id=$id");
exit;
?>