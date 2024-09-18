<?php
require_once 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if (!file_exists("config.json")) {
    echo "Error: config.json file not found.";
    exit;
}

$config = json_decode(file_get_contents("config.json"), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Error parsing config.json: ' . json_last_error_msg();
    exit;
}

function generateID() {
    $id = rand(10000000, 99999999);
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $stmt = $conn->prepare("SELECT * FROM govcitizen WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return generateID(); // ID already exists, generate a new one
    } else {
        return $id;
    }
}

function insertCitizen($id, $name, $surname, $age, $date_of_birth, $gender, $ethnicity, $citizenship, $born, $house, $mother, $father, $grandmother, $grandfather) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $stmt = $conn->prepare("INSERT INTO govcitizen (id, name, surname, age, date_of_birth, gender, ethnicity, citizenship, born, house, mother, father, grandmother, grandfather, govnotes, blocked) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $govnotes = '';
    $blocked = 0;
    $stmt->bind_param("isssssssssssssii", $id, $name, $surname, $age, $date_of_birth, $gender, $ethnicity, $citizenship, $born, $house, $mother, $father, $grandmother, $grandfather, $govnotes, $blocked);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

if (isset($_POST['create_id'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $age = $_POST['age'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $ethnicity = $_POST['ethnicity'];
    $citizenship = $_POST['citizenship'];
    $born = $_POST['born'];
    $house = $_POST['house'];
    $mother = $_POST['mother'];
    $father = $_POST['father'];
    $grandmother = $_POST['grandmother'];
    $grandfather = $_POST['grandfather'];

    $id = generateID();
    $result = insertCitizen($id, $name, $surname, $age, $date_of_birth, $gender, $ethnicity, $citizenship, $born, $house, $mother, $father, $grandmother, $grandfather);

    if ($result) {
        $message = "ID created successfully: $id";
    } else {
        $message = "Error creating ID.";
    }

    header("Location: index.php?message=" . urlencode($message));
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['message'])) {
    session_unset();
    session_destroy();
}
?>
<html>
<head>
    <title>Gov Citizen Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Gov Citizen Registration
    <?php
if (file_exists('install.php') && file_exists('install2.php')) {
    echo "<p style='color: red;'>Warning: Installation already completed! It is recommended to delete the install.php and install2.php files to prevent unauthorized access.</p>";
}
?>
    </h1>
    <?php if (isset($_GET['message'])) { ?>
        <p><?php echo $_GET['message']; ?></p>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname"><br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age"><br><br>
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth"><br><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>
        <label for="ethnicity">Ethnicity:</label>
 <input type="text" id="ethnicity" name="ethnicity"><br><br>
        <label for="citizenship">Citizenship:</label>
        <input type="text" id="citizenship" name="citizenship"><br><br>
        <label for="born">Born:</label>
        <input type="text" id="born" name="born"><br><br>
        <label for="house">House:</label>
        <input type="text" id="house" name="house"><br><br>
        <label for="mother">Mother:</label>
        <input type="text" id="mother" name="mother"><br><br>
        <label for="father">Father:</label>
        <input type="text" id="father" name="father"><br><br>
        <label for="grandmother">Grandmother:</label>
        <input type="text" id="grandmother" name="grandmother"><br><br>
        <label for="grandfather">Grandfather:</label>
        <input type="text" id="grandfather" name="grandfather"><br><br>
        <input type="submit" name="create_id" value="Create ID">
    </form>
    <p><a href="listcitizen.php">View Citizen List</a></p>
</body>
</html>