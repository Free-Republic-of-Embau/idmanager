<?php
session_start();
$config = json_decode(file_get_contents("config.json"), true);

// Check for errors parsing the JSON data
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'Error parsing config.json: ' . json_last_error_msg();
    exit;
}

// Define variables for database connection
$dathost = $config["dathost"];
$datusr = $config["datusr"];
$datpass = $config["datpass"];
$datname = $config["datname"];

// Validate and sanitize user input
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Check for SQL injection vulnerabilities
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) || !preg_match('/^[a-zA-Z0-9_]+$/', $password)) {
        echo "Invalid username or password";
        exit;
    }

    $conn = new mysqli($dathost, $datusr, $datpass, $datname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM govcuser WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        header("Location: index.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}

?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<link rel="stylesheet" type="text/css" href="style.css">
<label for="username">Username:</label>
<input type="text" id="username" name="username"><br><br>
<label for="password">Password:</label>
<input type="password" id="password" name="password"><br><br>
<input type="submit" value="Login">
</form>