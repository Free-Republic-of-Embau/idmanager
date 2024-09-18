<?php
require_once 'config.php';

$id = $_GET['id'];

$conn = new mysqli($dathost, $datusr, $datpass, $datname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM govcitizen WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Citizen not found with ID $id.";
} else {
    $citizen = $result->fetch_assoc();
    ?>
    <html>
    <head>
        <title>Citizen Profile</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Citizen Profile</h1>
        <table>
            <tr>
                <th>ID</th>
                <td><?= htmlspecialchars($citizen['id']); ?></td>
            </tr>
            <tr>
                <th>Name</th>
                <td><?= htmlspecialchars($citizen['name']); ?></td>
            </tr>
            <tr>
                <th>Surname</th>
                <td><?= htmlspecialchars($citizen['surname']); ?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?= htmlspecialchars($citizen['age']); ?></td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td><?= htmlspecialchars($citizen['date_of_birth']); ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?= htmlspecialchars($citizen['gender']); ?></td>
            </tr>
            <tr>
                <th>Ethnicity</th>
                <td><?= htmlspecialchars($citizen['ethnicity']); ?></td>
            </tr>
            <tr>
                <th>Citizenship</th>
                <td><?= htmlspecialchars($citizen['citizenship']); ?></td>
            </tr>
            <tr>
                <th>Born</th>
                <td><?= htmlspecialchars($citizen['born']); ?></td>
            </tr>
            <tr>
                <th>House</th>
                <td><?= htmlspecialchars($citizen['house']); ?></td>
            </tr>
            <tr>
                <th>Mother</th>
                <td><?= htmlspecialchars($citizen['mother']); ?></td>
            </tr>
            <tr>
                <th>Father</th>
                <td><?= htmlspecialchars($citizen['father']); ?></td>
            </tr>
            <tr>
                <th>Grandmother</th>
                <td><?= htmlspecialchars($citizen['grandmother']); ?></td>
            </tr>
            <tr>
                <th>Grandfather</th>
                <td><?= htmlspecialchars($citizen['grandfather']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= $citizen['blocked'] ? 'Blocked' : 'Active'; ?></td>
            </tr>
            <tr>
                <th>Gov Notes</th>
                <td><?= htmlspecialchars($citizen['govnotes']); ?></td>
            </tr>
        </table>
        <?php if (!$citizen['blocked']) { ?>
            <form action="block.php" method="post">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <input type="submit" value="Block ID">
            </form>
        <?php } else { ?>
            <form action="unblock.php" method="post">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <input type="submit" value="Unblock">
            </form>
        <?php } ?>
        
        <!-- Add a new input field for Gov Notes -->
        <form action="govnotes.php" method="post">
            <label for="govnotes">Gov Notes:</label>
            <textarea name="govnotes" id="govnotes" cols="30" rows="10"><?= htmlspecialchars($citizen['govnotes']); ?></textarea>
            <input type="hidden" name="id" value="<?= $id; ?>">
            <input type="submit" value="Update Gov Notes">
        </form>
        
        <p><a href="listcitizen.php">Return to Citizen List</a></p>
    </body>
    </html>
    <?php
}
$conn->close();
?>