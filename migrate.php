<?php
require_once 'config.php';
$conn = get_conn();

$cols = [
    'educational_qualification', 'prior_experience', 'experience_duration', 
    'godown_space', 'investment_capacity', 'sales_staff', 
    'service_staff', 'hear_about_us', 'why_join', 'expected_launch'
];

foreach ($cols as $col) {
    $check = $conn->query("SHOW COLUMNS FROM submissions LIKE '$col'");
    if ($check->num_rows == 0) {
        $conn->query("ALTER TABLE submissions ADD COLUMN $col VARCHAR(255)");
        echo "Added column: $col<br>";
    }
}

$conn->close();
echo "Migration complete!";
?>
