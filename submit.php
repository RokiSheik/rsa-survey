<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = get_conn();

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO submissions (
        name_of_wing, division_name, territory_name, zone_name, 
        zone_code, route_name, route_code, outlet_name, outlet_code, 
        retailer_name, retailer_number, surveyor_name, visit_date, 
        ads_10taka_plus, ads_slim_cigarette, ads_prime_cigarette, ads_mango_cigarette, 
        availability_prime, availability_mango, visibility_prime, 
        visibility_mango, buying_price_prime, buying_price_mango, 
        selling_price_prime, selling_price_mango, trade_scheme, 
        purchase_time, feedback_prime, feedback_mango
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssssssssssssssssssss", 
        $_POST['name_of_wing'], $_POST['division_name'], $_POST['territory_name'], $_POST['zone_name'],
        $_POST['zone_code'], $_POST['route_name'], $_POST['route_code'], $_POST['outlet_name'], $_POST['outlet_code'],
        $_POST['retailer_name'], $_POST['retailer_number'], $_POST['surveyor_name'], $_POST['visit_date'],
        $_POST['ads_10taka_plus'], $_POST['ads_slim_cigarette'], $_POST['ads_prime_cigarette'], $_POST['ads_mango_cigarette'],
        $_POST['availability_prime'], $_POST['availability_mango'], $_POST['visibility_prime'],
        $_POST['visibility_mango'], $_POST['buying_price_prime'], $_POST['buying_price_mango'],
        $_POST['selling_price_prime'], $_POST['selling_price_mango'], $_POST['trade_scheme'],
        $_POST['purchase_time'], $_POST['feedback_prime'], $_POST['feedback_mango']
    );

    if ($stmt->execute()) {
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
