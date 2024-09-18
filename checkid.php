<?php
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

// Create a new MySQLi connection
$conn = new mysqli($dathost, $datusr, $datpass, $datname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<html>
<head>
    <title>Check ID</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0 auto;
            width: 80%;
            padding: 20px;
            background-color: #f9f9f9;
        }
        form {
            margin: 20px auto;
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
        .result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .result.success {
            color: #2ecc71;
        }
        .result.error {
            color: #e74c3c;
        }
        </style>
</head>
<body>
    <h1>Check ID</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id">ID:</label>
        <input type="number" id="id" name="id">
        <input type="submit" value="Check ID">
    </form>

    <?php
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Validate input
        if (!is_numeric($id) || $id < 1 || strlen($id) != 8) {
            echo "Invalid ID";
            exit;
        }

        // Query to retrieve the citizen's information
        $stmt = $conn->prepare("SELECT blocked FROM govcitizen WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the citizen exists
        if ($result->num_rows == 0) {
            $result_text = "ID not found.";
            $result_class = "error";
        } else {
            $citizen = $result->fetch_assoc();
            if ($citizen['blocked'] == 1) {
                $result_text = "ID is blocked.";
                $result_class = "error";
            } else {
                $result_text = "ID is valid and active.";
                $result_class = "success";
            }
        }
        ?>
        <p class="result <?php echo $result_class; ?>"><?php echo $result_text; ?></p>
        <?php
    }
    ?>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>