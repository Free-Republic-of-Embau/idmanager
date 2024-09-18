<?php
// Check if the config.json file exists
if (!file_exists("config.json")) {
    echo "Error: config.json file not found.";
    exit;
}

// Read the config.json file
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

// Create a form to input the username and password
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Install" name="install">
</form>

<?php
// Check if the form has been submitted and the install button is clicked
if (isset($_POST["install"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the input
    if (empty($username) || empty($password)) {
        echo "Please fill in both fields.";
        exit;
    }

    // Create a new MySQLi connection
    $conn = new mysqli($dathost, $datusr, $datpass, $datname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create the database tables
    $sql = "CREATE TABLE govcitizen (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        age INT(3) NOT NULL
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table govcitizen created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    $sql = "CREATE TABLE govcuser (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(30) NOT NULL
    )";
    

    if ($conn->query($sql) === TRUE) {
        echo "Table govcuser created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    // Insert the admin user into the database
    $sql = "INSERT INTO govcuser (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    echo "Installation complete!";
    $conn->close();
}
?>