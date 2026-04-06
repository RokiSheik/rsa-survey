<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = get_conn();

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO submissions (
        firm_name, owner_name, personal_phone, office_phone, 
        email, city_state, pin_code, gst_no, pan_no, 
        nature_of_business, monthly_sale, years_in_business, 
        no_employee, experience, existing_brand_dealer, 
        area_covering, office_godown, any_other_business, 
        turnover, educational_qualification, prior_experience, 
        experience_duration, godown_space, investment_capacity, 
        sales_staff, service_staff, hear_about_us, 
        why_join, expected_launch, product_interest
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $product_interest = isset($_POST['product_interest']) ? implode(', ', $_POST['product_interest']) : 'None Selected';

    $stmt->bind_param("ssssssssssssssssssssssssssssss", 
        $_POST['firm_name'], $_POST['owner_name'], $_POST['personal_phone'], $_POST['office_phone'],
        $_POST['email'], $_POST['city_state'], $_POST['pin_code'], $_POST['gst_no'], $_POST['pan_no'],
        $_POST['nature_of_business'], $_POST['monthly_sale'], $_POST['years_in_business'],
        $_POST['no_employee'], $_POST['experience'], $_POST['existing_brand_dealer'],
        $_POST['area_covering'], $_POST['office_godown'], $_POST['any_other_business'],
        $_POST['turnover'], $_POST['educational_qualification'], $_POST['prior_experience'],
        $_POST['experience_duration'], $_POST['godown_space'], $_POST['investment_capacity'],
        $_POST['sales_staff'], $_POST['service_staff'], $_POST['hear_about_us'],
        $_POST['why_join'], $_POST['expected_launch'], $product_interest
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
