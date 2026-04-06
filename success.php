<?php
require_once 'config.php';
$conn = get_conn();
$settings = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
$site_name = $settings['site_name'] ?? 'RSA Dealership';
$logo_path = $settings['logo_path'] ?? '';
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success - <?php echo $site_name; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full p-8 bg-white shadow-2xl rounded-3xl text-center border border-green-100">
        <div class="mb-6 flex justify-center">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Application Submitted!</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Thank you for your interest in joining <strong><?php echo $site_name; ?></strong>. 
            We have received your application successfully. Our team will review your details and get back to you shortly.
        </p>

        <a href="index.php" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            Back to Home
        </a>
    </div>
</body>
</html>
