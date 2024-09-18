<?php
require_once 'config.php';

$id = $_POST['id'];
$govnotes = $_POST['govnotes'];

$conn = new mysqli($dathost, $datusr, $datpass, $datname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE govcitizen SET govnotes = ? WHERE id = ?");
$stmt->bind_param("si", $govnotes, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Gov notes updated successfully.";
} else {
    echo "Error updating gov notes.";
}

$conn->close();

header("Location: profile.php?id=$id");
exit;
?>