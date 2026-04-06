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
    firm_name VARCHAR(255),
    owner_name VARCHAR(255),
    personal_phone VARCHAR(255),
    office_phone VARCHAR(255),
    email VARCHAR(255),
    city_state VARCHAR(255),
    pin_code VARCHAR(255),
    gst_no VARCHAR(255),
    pan_no VARCHAR(255),
    nature_of_business VARCHAR(255),
    monthly_sale VARCHAR(255),
    years_in_business VARCHAR(255),
    no_employee VARCHAR(255),
    experience VARCHAR(255),
    existing_brand_dealer VARCHAR(255),
    area_covering VARCHAR(255),
    office_godown VARCHAR(255),
    any_other_business VARCHAR(255),
    turnover VARCHAR(255),
    product_interest TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table submissions created successfully<br>";
} else {
    echo "Error creating table submissions: " . $conn->error . "<br>";
}

$conn->close();
?>
