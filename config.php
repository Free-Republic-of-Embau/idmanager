<?php
// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Check if the session has been inactive for more than 30 minutes
    if (isset($_SESSION['timeout']) && $_SESSION['timeout'] + 1800 < time()) {
        session_unset();
        session_destroy();
    } else {
        // Update the session timeout
        $_SESSION['timeout'] = time();
    }
}

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
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
} else {
    // Define variables as null if not logged in
    $dathost = null;
    $datusr = null;
    $datpass = null;
    $datname = null;
}
?>
