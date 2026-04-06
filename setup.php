<?php
require_once 'config.php';

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Database
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->select_db(DB_NAME);

// Create settings table
$sql = "CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(255) NOT NULL,
    logo_path VARCHAR(255) DEFAULT NULL,
    admin_user VARCHAR(255) DEFAULT 'Admin',
    admin_pass VARCHAR(255) DEFAULT 'Admin123'
)";

if ($conn->query($sql) === TRUE) {
    echo "Table settings created successfully<br>";
    // Insert default settings
    $check = $conn->query("SELECT * FROM settings LIMIT 1");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO settings (site_name, admin_user, admin_pass) VALUES ('RSA Dealership', 'Admin', 'Admin123')");
    }
} else {
    echo "Error creating table settings: " . $conn->error . "<br>";
}

// Create submissions table
$sql = "CREATE TABLE IF NOT EXISTS submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_of_wing VARCHAR(255),
    division_name VARCHAR(255),
    territory_name VARCHAR(255),
    zone_name VARCHAR(255),
    zone_code VARCHAR(255),
    route_name VARCHAR(255),
    route_code VARCHAR(255),
    outlet_name VARCHAR(255),
    outlet_code VARCHAR(255),
    retailer_name VARCHAR(255),
    retailer_number VARCHAR(255),
    surveyor_name VARCHAR(255),
    visit_date DATE,
    ads_10taka_plus VARCHAR(255),
    ads_slim_cigarette VARCHAR(255),
    ads_prime_cigarette VARCHAR(255),
    ads_mango_cigarette VARCHAR(255),
    availability_prime VARCHAR(255),
    availability_mango VARCHAR(255),
    visibility_prime VARCHAR(255),
    visibility_mango VARCHAR(255),
    buying_price_prime VARCHAR(255),
    buying_price_mango VARCHAR(255),
    selling_price_prime VARCHAR(255),
    selling_price_mango VARCHAR(255),
    trade_scheme VARCHAR(255),
    purchase_time VARCHAR(255),
    feedback_prime VARCHAR(255),
    feedback_mango VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table submissions created successfully<br>";
} else {
    echo "Error creating table submissions: " . $conn->error . "<br>";
}

$conn->close();
?>
