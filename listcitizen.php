<?php
require_once 'config.php';

// Set the number of citizens to display per page
$per_page = 10;

// Get the current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $per_page;

// Create a new MySQLi connection
$conn = new mysqli($dathost, $datusr, $datpass, $datname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare a query to retrieve the citizens
$stmt = $conn->prepare("SELECT id, name, surname, age FROM govcitizen LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Get the total number of citizens
$stmt = $conn->prepare("SELECT COUNT(*) FROM govcitizen");
$stmt->execute();
$total_citizens = $stmt->get_result()->fetch_assoc()['COUNT(*)'];

// Calculate the total number of pages
$total_pages = ceil($total_citizens / $per_page);

?>
<html>
<head>
    <title>Citizen List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Citizen List</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Age</th>
            <th>Open Profile</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['id']); ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['surname']); ?></td>
            <td><?= htmlspecialchars($row['age']); ?></td>
            <td><button><a href="profile.php?id=<?= htmlspecialchars($row['id']); ?>">Open Profile</a></button></td>
        </tr>
        <?php } ?>
    </table>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="listcitizen.php?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php } ?>
    </div>
    <p><a href="index.php">Return to Registration</a></p>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>