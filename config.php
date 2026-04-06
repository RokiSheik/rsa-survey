<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'survey_db');

// Connect to MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select the database
if (!$conn->select_db(DB_NAME)) {
    // If database doesn't exist, we might want to handle it or create it in setup.php
}

function get_conn() {
    $c = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($c->connect_error) {
        die("Connection failed: " . $c->connect_error);
    }
    return $c;
}
?>
