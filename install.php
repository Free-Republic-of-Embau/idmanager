<?php
// Create a form to input the database credentials
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="dathost">Database Host:</label>
    <input type="text" id="dathost" name="dathost"><br><br>
    <label for="datusr">Database Username:</label>
    <input type="text" id="datusr" name="datusr"><br><br>
    <label for="datpass">Database Password:</label>
    <input type="password" id="datpass" name="datpass"><br><br>
    <label for="datname">Database Name:</label>
    <input type="text" id="datname" name="datname"><br><br>
    <input type="submit" value="Generate Config">
</form>

<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are filled
    if (isset($_POST["dathost"]) && isset($_POST["datusr"]) && isset($_POST["datpass"]) && isset($_POST["datname"])) {
        $dathost = $_POST["dathost"];
        $datusr = $_POST["datusr"];
        $datpass = $_POST["datpass"];
        $datname = $_POST["datname"];

        // Validate the input
        if (empty($dathost) || empty($datusr) || empty($datpass) || empty($datname)) {
            echo "Please fill in all fields.";
        } else {
            // Create the config.json file
            $config = array(
                "dathost" => $dathost,
                "datusr" => $datusr,
                "datpass" => $datpass,
                "datname" => $datname
            );

            $json = json_encode($config, JSON_PRETTY_PRINT);

            file_put_contents("config.json", $json);

            echo "Config file generated successfully!<br><br>";

            // Redirect to install2.php
            header("Location: install2.php");
            exit;
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>